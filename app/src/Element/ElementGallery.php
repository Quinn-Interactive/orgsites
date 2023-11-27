<?php

namespace QI\App\Element;

use DNADesign\Elemental\Models\ElementContent;
use QI\App\Model\GalleryItem;
use SilverStripe\Forms\FieldGroup;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use TractorCow\Fluent\Forms\VisibleLocalesColumn;

/**
 * Class \QI\App\Element\ElementVideoCarousel
 *
 * @property bool $Slider
 * @method \SilverStripe\ORM\DataList|\QI\App\Model\GalleryItem[] GalleryItems()
 */
class ElementGallery extends ElementContent
{
    private static $db = [
        'Slider' => 'Boolean',
    ];
    private static $has_many = [
        'GalleryItems' => GalleryItem::class,
    ];

    private static $icon = 'font-icon-block-carousel';
    private static $inline_editable = false;
    private static $owns = [
        'GalleryItems',
    ];
    private static $table_name = 'ElementGallery';

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

        // GalleryItems
        /** @var GridField */
        $galleryItems = $fields->dataFieldByName('GalleryItems');
        if ($galleryItems) {
            $config = $galleryItems->getConfig();
            $config->addComponent(new GridFieldOrderableRows('Sort'));
            $config->removeComponentsByType(GridFieldAddExistingAutocompleter::class);
            $config->addComponent(new VisibleLocalesColumn());
            $fields->removeByName('GalleryItems');
            $fields->addFieldToTab('Root.Main', $galleryItems);
        }

        return $fields;
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Gallery');
    }
}
