<?php

namespace QuinnInteractive\Orgsite\Model;

use QuinnInteractive\Orgsite\Lib\GroupFields;
use QuinnInteractive\Orgsite\Lib\Helpers;
use QuinnInteractive\Orgsite\Page\Calendar;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Blog\Model\BlogPost;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\DatetimeField;
use SilverStripe\Forms\ToggleCompositeField;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\Filters\PartialMatchFilter;
use SilverStripe\Versioned\Versioned;
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
 * @property bool $ShowTimes
 * @property int $CalendarID
 * @property int $FeaturedImageID
 * @method \QuinnInteractive\Orgsite\Page\Calendar Calendar()
 * @method \SilverStripe\Assets\Image FeaturedImage()
 * @mixin \SilverStripe\Versioned\Versioned
 * @mixin \TractorCow\Fluent\Extension\FluentVersionedExtension
 */
class Event extends DataObject
{
    private static $db = [
        'Title'       => 'Varchar(128)',
        'Start'       => 'DBDatetime',
        'End'         => 'DBDatetime',
        'DisplayDate' => 'Varchar(128)',
        'ShowTimes'   => 'Boolean',
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

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('CalendarID');

        // Dates
        $start = $this->ShowTimes ? DatetimeField::create('Start') : DateField::create('Start');
        $end = $this->ShowTimes ? DatetimeField::create('End') : DateField::create('End');
        $fields->replaceField('Start', $start);
        $fields->replaceField('End', $end);
        $end->setTitle('End (optional)');
        $start->setTitle('Start (required)');
        GroupFields::create(['Start', 'End', 'ShowTimes'], 'Dates', $fields, 'Summary');

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
    public function Link($action = 'view')
    {
        // if we don't have any content, then we don't need a link
        if (!$this->Content) {
            return null;
        }
        $base = $this->Calendar()->Link();
        $slug = Helpers::generate_slug($this->Title);
        $url = Controller::join_links($base, $action, $this->ID, $slug);
        return $url;
    }

    public function Parent()
    {
        return $this->Calendar();
    }
}
