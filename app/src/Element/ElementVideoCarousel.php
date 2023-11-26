<?php

namespace QI\App\Element;

use DNADesign\Elemental\Models\ElementContent;
use QI\App\Model\Video;
use SilverStripe\Forms\FieldGroup;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use TractorCow\Fluent\Forms\VisibleLocalesColumn;

/**
 * Class \QI\App\Element\ElementVideoCarousel
 *
 * @property bool $Slider
 * @method \SilverStripe\ORM\DataList|\QI\App\Model\Video[] Videos()
 */
class ElementVideoCarousel extends ElementContent
{

    private static $icon = 'font-icon-block-video';
    private static $table_name = 'ElementVideoCarousel';
    private static $inline_editable = false;
    private static $db = [
        'Slider' => 'Boolean',
    ];
    private static $has_many = [
        'Videos' => Video::class,
    ];
    private static $owns = [
        'Videos',
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        // Slider
        $slider = $fields->dataFieldByName('Slider');
        if ($slider) {
            $slider->setTitle('Show as slider instead of grid');
            $fields->removeByName('Slider');
            $fields->insertAfter('HTML', FieldGroup::create('Slider or Grid', $slider));
        }

        // HTML
        $fields->dataFieldByName('HTML')
            ->setDescription('Optional. Will show above videos')
            ->setRows(7);

        // Videos
        /** @var GridField */
        $videos = $fields->dataFieldByName('Videos');
        if ($videos) {
            $config = $videos->getConfig();
            $config->addComponent(new GridFieldOrderableRows('Sort'));
            $config->removeComponentsByType(GridFieldAddExistingAutocompleter::class);
            $config->addComponent(new VisibleLocalesColumn());
            $fields->removeByName('Videos');
            $fields->addFieldToTab('Root.Main', $videos);
        }

        return $fields;
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'VideoCarousel');
    }
}
