<?php

namespace QI\App\Model;

use QI\App\Lib\GroupFields;
use QI\App\Lib\Helpers;
use QI\App\Page\Calendar;
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
 * Class \QI\App\Model\Event
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
 * @method \QI\App\Page\Calendar Calendar()
 * @method \SilverStripe\Assets\Image FeaturedImage()
 * @mixin \SilverStripe\Versioned\Versioned
 * @mixin \TractorCow\Fluent\Extension\FluentVersionedExtension
 */
class Event extends DataObject
{
    private static $db = [
        'Title'       => 'Varchar(128)',
        'Content'     => 'HTMLText',
        'Summary'     => 'HTMLText',
        'Start'       => 'DBDatetime',
        'End'         => 'DBDatetime',
        'DisplayDate' => 'Varchar(128)',
        'ShowTimes'   => 'Boolean',
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
        GroupFields::create(['Start', 'End', 'ShowTimes'], 'Dates', $fields, 'Content');
        
        // Display Date
        $displayDate = $fields->dataFieldByName('DisplayDate')->setDescription('Optional. Will show up instead of set dates, if not empty.');
        $fields->insertAfter('Dates', $displayDate);
        // Featured Image
        /** @var UploadField */
        $featuredImage = $fields->dataFieldByName('FeaturedImage');
        $featuredImage->setFolderName('Event-Images');
        if ($featuredImage) {
            $fields->removeByName('FeaturedImage');
            $fields->insertBefore('Content', $featuredImage);
        }

        // Summary
        $summary = $fields->dataFieldByName('Summary');
        $summary->setRows(5);
        $summary->setDescription(_t(
            BlogPost::class . '.SUMMARY_DESCRIPTION',
            'If no summary is specified the first 30 words will be used.'
        ));

        $summaryHolder = ToggleCompositeField::create(
            'CustomSummary',
            _t(BlogPost::class . '.CUSTOMSUMMARY', 'Add A Custom Summary'),
            [
                $summary,
            ]
        );
        $summaryHolder->setHeadingLevel(4);
        $summaryHolder->addExtraClass('custom-summary');

        if ($this->Summary) {
            $summaryHolder->setStartClosed(false);
        }
        $fields->removeByName('Summary');
        $fields->insertAfter('FeaturedImage', $summaryHolder);

        return $fields;
    }

    /**
     * Figure out a link for this for the front end
     *
     * @return string
     */
    public function Link($action = null)
    {
        $base = $this->Calendar()->Link();
        $action = $action != 'view' ? $action : null;
        // add ID and slug
        $slug = Helpers::generate_slug($this->Title);
        $url = Controller::join_links($base, $action, $this->ID, $slug);
        return $url;
    }
}
