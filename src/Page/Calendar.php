<?php

namespace QuinnInteractive\Orgsite\Page;

use CalendarController;
use DateTimeZone;
use Page;
use QuinnInteractive\Orgsite\Lib\Helpers;
use QuinnInteractive\Orgsite\Model\Event;
use SilverStripe\Dev\Debug;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\NumericField;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\ValidationResult;
use TractorCow\Fluent\Forms\VisibleLocalesColumn;

/**
 * Class \QuinnInteractive\Orgsite\Page\Calendar
 *
 * @property int $PostsPerPage
 * @method \SilverStripe\ORM\DataList|\QuinnInteractive\Orgsite\Model\Event[] Events()
 */
class Calendar extends Page
{
    private static $controller_name = CalendarController::class;
    private static $db = [
        'PostsPerPage' => 'Int',
        'ICalendar'    => 'Boolean',
        'Timezone'     => 'Varchar(32)',
    ];
    private static $defaults = [
        'PostsPerPage' => 10
    ];
    private static $has_many = [
        'Events' => Event::class,
    ];
    private static $icon_class = 'font-icon-p-event-alt';
    private static $table_name = 'Calendar';

    public function getCMSFields()
    {
        // wrapped so that we get our tab before the Localization tab
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            // PostsPerPage
            $fields->addFieldToTab(
                'Root.Main',
                NumericField::create('PostsPerPage', _t(__CLASS__ . '.PostsPerPage', 'Posts Per Page')),
                'Content'
            );

            // ICalendar
            $fields->addFieldToTab(
                'Root.Main',
                CheckboxField::create('ICalendar', _t(__CLASS__ . '.ICalendar', 'Allow iCalendar Feed?')),
                'Content'
            );


            $fields->addFieldToTab(
                'Root.Main',
                DropdownField::create('Timezone', 'Timezone', Helpers::timezone_array())
                ->setTitle('Timezone')
                ->setDescription('Recommended. The default timezone for this calendar’s events. Used in iCalendar events to make sure they show up at the correct time in people’s calendars. Can be overriden on individual events.')
                ->setEmptyString('Choose a timezone'),
                'MenuTitle'
            );

            // Events
            $config = GridFieldConfig_RelationEditor::create();
            $config->removeComponentsByType(GridFieldAddExistingAutocompleter::class);
            $config->addComponent(new VisibleLocalesColumn());
            $events = GridField::create('Events', 'Events', $this->Events(), $config);
            $fields->addFieldToTab('Root.Events', $events);
        });
        return parent::getCMSFields();
    }

    public function PastEvents(): DataList
    {
        return $this->Events()->filterAny([
            'Start:LessThan' => date('Y-m-d'),
        ])->Sort('Start', 'DESC');
    }

    // for use on Element Promos block
    public function Promos(): DataList
    {
        return $this->UpcomingEvents();
    }

    public function UpcomingEvents(): DataList
    {
        return $this->Events()->filterAny([
            'Start:GreaterThanOrEqual' => date('Y-m-d'),
            'End:GreaterThanOrEqual'   => date('Y-m-d'),
        ])->Sort('Start', 'ASC');
    }

    public function getCalendarClearKey(): ?string
    {
        return "calender-{$this->ID}" . hash('md5', $this->ClearKey('Calendar'));
    }
}
