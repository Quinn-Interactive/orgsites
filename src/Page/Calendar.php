<?php

namespace QuinnInteractive\Orgsite\Page;

use CalendarController;
use Page;
use QuinnInteractive\Orgsite\Model\Event;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\NumericField;
use SilverStripe\ORM\DataList;
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
        'ICalendar' => 'Boolean',
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
}
