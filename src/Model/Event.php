<?php

namespace QuinnInteractive\Orgsite\Model;

use DateTime;
use DateTimeZone;
use Psr\SimpleCache\CacheInterface;
use QuinnInteractive\Orgsite\Lib\GroupFields;
use QuinnInteractive\Orgsite\Lib\Helpers;
use QuinnInteractive\Orgsite\Page\Calendar;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Blog\Model\BlogPost;
use SilverStripe\Control\Controller;
use SilverStripe\Control\Director;
use SilverStripe\Core\Flushable;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\Filters\PartialMatchFilter;
use SilverStripe\Versioned\Versioned;
use Spatie\IcalendarGenerator\Components\Event as ComponentsEvent;
use TractorCow\Fluent\Extension\FluentVersionedExtension;

/**
 * Class \QuinnInteractive\Orgsite\Model\Event
 *
 * @property int $Version
 * @property string $Title
 * @property string $Content
 * @property string $Summary
 * @property string $Start
 * @property string $End
 * @property string $DisplayDate
 * @property int $CalendarID
 * @property int $FeaturedImageID
 * @method \QuinnInteractive\Orgsite\Page\Calendar Calendar()
 * @method \SilverStripe\Assets\Image FeaturedImage()
 * @mixin \SilverStripe\Versioned\Versioned
 * @mixin \TractorCow\Fluent\Extension\FluentVersionedExtension
 */
class Event extends DataObject implements Flushable
{
    private static $db = [
        'Title'       => 'Varchar(128)',
        'Start'       => 'DBDatetime',
        'End'         => 'DBDatetime',
        'DisplayDate' => 'Varchar(128)',
        'AllDay'      => 'Boolean',
        'Timezone'    => 'Varchar(32)',
        'Summary'     => 'HTMLText',
        'Content'     => 'HTMLText',
    ];
    private static $default_sort = 'Start DESC';
    private static $extensions = [
        Versioned::class,
        FluentVersionedExtension::class,
    ];
    private static $has_one = [
        'Calendar'      => Calendar::class,
        'FeaturedImage' => Image::class,
    ];
    private static $owns = [
        'FeaturedImage',
    ];
    private static $searchable_fields = [
        'Title'   => PartialMatchFilter::class,
        'Content' => PartialMatchFilter::class,
    ];
    private static $summary_fields = [
        'Title',
        'Start',
        'End',
    ];
    private static $table_name = 'Event';

    /**
     * Find the best summary for indexes and cards and promos
     * return the first x characters that are complete words
     * unless the last character is a period, add an ellipsis
     *
     * @param int     $chars (optional)
     * @return string
     */
    public function DescriptionOrSummary($chars = 500)
    {
        $html = $this->Summary ?? $this->Content;
        return Helpers::html_to_limited_text($html, $chars);
    }

    /**
     * Returns the post excerpt.
     *
     * @param int $wordsToDisplay
     *
     * @return string
     */
    public function Excerpt($wordsToDisplay = 30)
    {
        /** @var DBHTMLText $content */
        $content = $this->dbObject('Content');

        return $content->Summary($wordsToDisplay);
    }

    public function getCalculatedTimezone(): ?DateTimeZone
    {
        $timezone = $this->Timezone ?? $this->Calendar()->Timezone ?? null;
        if ($timezone) {
            return new DateTimeZone($timezone);
        }
        return null;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('CalendarID');

        // Dates
        $start = $fields->dataFieldByName('Start');
        $end = $fields->dataFieldByName('End');
        $end->setTitle('End (optional)');
        $start->setTitle('Start (required)');
        GroupFields::create(['Start', 'End', 'AllDay'], 'Dates', $fields, 'Summary');

        // Display Date
        $displayDate = $fields->dataFieldByName('DisplayDate')->setDescription('Optional. Will show up instead of set dates, if not empty.');
        $fields->insertAfter('Dates', $displayDate);
        // Featured Image
        /** @var UploadField */
        $featuredImage = $fields->dataFieldByName('FeaturedImage');
        $featuredImage->setFolderName('Event-Images');
        if ($featuredImage) {
            $fields->removeByName('FeaturedImage');
            $fields->insertBefore('Summary', $featuredImage);
        }

        // Timezone
        $defaultTimezone = $this->Calendar()->Timezone ?? 'unset';
        $timezone = DropdownField::create('Timezone', 'Timezone', Helpers::timezone_array())
        ->setTitle('Timezone')
        ->setDescription("Optional. Override calendar’s default timezone ($defaultTimezone) for use in iCal downloads.")
        ->setEmptyString('Choose a timezone');
        $fields->insertAfter('DisplayDate', $timezone);

        // Content
        $fields->dataFieldByName('Content')->setDescription(_t(
            BlogPost::class . '.CONTENT_DESCRIPTION',
            'If empty, event will show in Calendar listing, but will not be linked to a page.'
        ));

        // Summary
        $summary = $fields->dataFieldByName('Summary');
        $summary->setRows(5);
        $summary->setDescription(_t(
            BlogPost::class . '.SUMMARY_DESCRIPTION',
            'Used on Calendar listing. If no summary is specified the first 30 words of the Content will be used.'
        ));

        // $fields->insertAfter('FeaturedImage', $summary);

        return $fields;
    }

    /**
     * Figure out a link for this for the front end
     *
     * @return ?string
     */
    public function Link($action = 'event')
    {
        // if we don't have any content, then we don't need a link
        if (!$this->Content) {
            return null;
        }
        $base = $this->Calendar()->Link();
        $url = Controller::join_links($base, $action, $this->ID, $this->getSlug());
        return $url;
    }

    public function getSlug(): string
    {
        return Helpers::generate_slug($this->Title);
    }

    public function iCalLink(): ?string
    {
        if ($this->Parent()->ICalendar) {
            $base = $this->Calendar()->Link();
            $url = Controller::join_links($base, 'event-ical', $this->ID, "{$this->getSlug()}.ics");
            return $url;
        }
    }

    public function Parent()
    {
        return $this->Calendar();
    }

    public function iCal(): ComponentsEvent
    {
        $timezone = $this->getCalculatedTimezone();
    
        $ical = ComponentsEvent::create()
        ->name($this->Title)
        ->description($this->DescriptionOrSummary())
        ->uniqueIdentifier($this->ID)
        ->createdAt(new DateTime($this->Created, $timezone))
        ->startsAt(new DateTime($this->Start, $timezone));

        if ($this->End) {
            $ical->endsAt(new DateTime($this->End, $timezone));
        }
        if ($this->AllDay) {
            $ical->fullDay();
        }
        /** @var Image $image */
        $image = $this->FeaturedImage();
        if ($image && $image->exists() && $image->canView()) {
            $ical->image(Director::absoluteURL($image->getURL()));
        }

        if (!$this->getCalculatedTimezone()) {
            $ical->withoutTimezone();
        }

        return $ical;

    }

    public static function flush()
    {
        $cache = self::get_cache();
        $cache->clear();
    }

    private static function get_cache()
    {
        return Injector::inst()->get(CacheInterface::class . '.calendarCache');
    }
}
