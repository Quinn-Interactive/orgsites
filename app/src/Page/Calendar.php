<?php

namespace QI\App\Page;

use CalendarController;
use Page;
use QI\App\Model\Event;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\NumericField;
use TractorCow\Fluent\Forms\VisibleLocalesColumn;

/**
 * Class \QI\App\Page\Calendar
 *
 * @property int $PostsPerPage
 * @method \SilverStripe\ORM\DataList|\QI\App\Model\Event[] Events()
 */
class Calendar extends Page
{
    private static $controller_name = CalendarController::class;
    private static $db = [
        'PostsPerPage' => 'Int',
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
            // Events
            $config = GridFieldConfig_RelationEditor::create();
            $config->removeComponentsByType(GridFieldAddExistingAutocompleter::class);
            $config->addComponent(new VisibleLocalesColumn());
            $events = GridField::create('Events', 'Events', $this->Events(), $config);
            $fields->addFieldToTab('Root.Events', $events);
        });
        return parent::getCMSFields();
    }
}
