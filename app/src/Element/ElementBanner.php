<?php

namespace QI\App\Element;

use DNADesign\Elemental\Models\ElementContent;
use QI\App\Lib\Helpers;
use SilverStripe\Assets\Image;
use SilverStripe\Dev\Debug;

/**
 * Class \QI\App\Element\ElementBanner
 *
 * @property string $TextPosition
 * @property int $ImageID
 * @method \SilverStripe\Assets\Image Image()
 */
class ElementBanner extends ElementContent
{
    private static $db = [
        'TextPosition' => "Enum('top,bottom,right,left,center', 'bottom')",
    ];
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

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        // TextPosition
        Helpers::localize_select($fields->dataFieldByName('TextPosition'), $this);

        // HTML
        $fields->dataFieldByName('HTML')->setDescription(_t(self::class . '.OPTIONAL', 'Optional'));

        // Image
        $fields->dataFieldByName('Image')
            ->setFolderName('Banners')
            ->setDescription(_t(self::class . '.Image_Description', 'Best size: 3840 × 2160. Use Focus point to make sure focus area stays in frame.'));

        return $fields;
    }
    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Banner');
    }
}
