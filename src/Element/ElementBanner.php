<?php

namespace QuinnInteractive\Orgsite\Element;

use DNADesign\Elemental\Models\ElementContent;
use Page;
use QuinnInteractive\Orgsite\Lib\Helpers;
use SilverStripe\Assets\Image;
use SilverStripe\Assets\Storage\DBFile;
use SilverStripe\Dev\Debug;

/**
 * Class \QuinnInteractive\Orgsite\Element\ElementBanner
 *
 * @property string $TextPosition
 * @property string $TextColor
 * @property int $ImageID
 * @method \SilverStripe\Assets\Image Image()
 */
class ElementBanner extends ElementContent
{
    private static $db = [
        'TextPosition' => "Enum('top,bottom,right,left,center', 'bottom')",
        'TextColor'    => "Enum('white,black', 'white')",
    ];
    // private static $inline_editable = false;
    private static $disable_background_color = true;
    private static $has_one = [
        'Image' => Image::class,
    ];
    private static $icon = 'font-icon-block-banner';
    private static $owns = [
        'Image',
    ];
    private static $plural_name = 'Banners';
    private static $singular_name = 'Banner';
    private static $table_name = 'ElementBanner';
    private static $title = 'Banner';
    private static $translate = [
        'HTML',
        'ImageID',
    ];

    public function getCMSFields()
    {
        // Debug::dump($this->getBlockConfig()); die;
        $fields = parent::getCMSFields();
        $fields->removeByName('ElementSlideshowID');

        // TextPosition
        Helpers::localize_select($fields->dataFieldByName('TextPosition'), $this);

        // HTML
        $fields->dataFieldByName('HTML')->setDescription(_t(Page::class . '.OPTIONAL', 'Optional'));

        // Image
        $fields->dataFieldByName('Image')
            ->setFolderName('Banners')
            ->setDescription(_t(self::class . '.Image_Description', 'Best size: 3840 × 2160. Use Focus point to make sure focus area stays in frame.'));

        return $fields;
    }

    /**
     * override default style variant
     *
     * @return string
     */
    public function getStyleVariant()
    {
        $color = $this->TextColor;
        if ($color == 'white') {
            return 'text-bg-dark';
        }
        return 'text-bg-light';
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Banner');
    }
}
