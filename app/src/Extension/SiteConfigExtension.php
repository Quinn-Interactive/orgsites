<?php

namespace QI\App\Extension;

use RyanPotter\SilverStripeColorField\Forms\ColorField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\File;
use SilverStripe\Dev\Debug;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HeaderField;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\View\ArrayData;
use TractorCow\Colorpicker\Color;
// use TractorCow\Colorpicker\Forms\ColorField;
use TractorCow\Fluent\Extension\FluentExtension;

/**
 * Class \QI\App\Extension\SiteConfigExtension
 *
 * uses:
 * - data type: https://github.com/tractorcow/silverstripe-colorpicker
 * - edit field: https://github.com/Rhym/silverstripe-color-field
 *
 * @property \SilverStripe\SiteConfig\SiteConfig|\QI\App\Extension\SiteConfigExtension $owner
 * @property string $PrimaryColor
 * @property string $SecondaryColor
 * @property string $SuccessColor
 * @property string $DangerColor
 * @property string $WarningColor
 * @property string $InfoColor
 * @property string $LightColor
 * @property string $DarkColor
 * @property int $LogoID
 * @method \SilverStripe\Assets\File Logo()
 */
class SiteConfigExtension extends FluentExtension
{
    private static $db = [
        'PrimaryColor'   => 'Varchar(7)',
        'SecondaryColor' => 'Varchar(7)',
        'SuccessColor'   => 'Varchar(7)',
        'DangerColor'    => 'Varchar(7)',
        'WarningColor'   => 'Varchar(7)',
        'InfoColor'      => 'Varchar(7)',
        'LightColor'     => 'Varchar(7)',
        'DarkColor'      => 'Varchar(7)',
    ];

    private static $defaults = [
        'PrimaryColor'   => '#0d6efd',
        'SecondaryColor' => '#6c757d',
        'SuccessColor'   => '#198754',
        'DangerColor'    => '#dc3545',
        'WarningColor'   => '#ffc107',
        'InfoColor'      => '#0dcaf0',
        'LightColor'     => '#f8f9fa',
        'DarkColor'      => '#212529',
    ];

    private static $has_one = [
        'Logo' => File::class,
    ];
    private static $owns = [
        'Logo',
    ];
    private static $translate = [
        'Title',
        'Tagline',
    ];

    public function onBeforeWrite(): void
    {
        $colors = $this->owner->config()->get('colors');
        foreach ($colors as $field => $value) {
            $test = ltrim($this->owner->$field, '#');
            if(!ctype_xdigit(strtoupper($test)) || strlen($test) != 6) {
                $this->owner->$field = $value['default'];
            }
        }
    }

    public function updateCMSFields(FieldList $fields): void
    {
        // Logo
        $logoField = UploadField::create('Logo', 'Logo');
        $logoField->setAllowedExtensions(['png', 'jpg', 'gif', 'svg'])
            ->setDescription('Small PNG, JPEG, GIF, or SVG file. This logo is shared across all locales.')
            ->setFolderName('SiteLogo');
        $fields->addFieldToTab('Root.Main', $logoField);

        // Colors
        $fields->addFieldToTab('Root.Main', HeaderField::create('ColorsHeader', 'Colors'));
        $colors = $this->owner->config()->get('colors');
        foreach ($colors as $key => $color) {
            $colorField = ColorField::create($key, $color['title'])
                ->setDescription($color['description'])
                ->setRightTitle("Default: {$color['default']}");
            $fields->addFieldToTab('Root.Main', $colorField);
        }

        parent::updateCMSFields($fields);
    }

    public function Color($name) {
        $fieldName = $name . 'Color';
        if ($this->owner->hasField($fieldName)) {
            return DBField::create_field('Color', ltrim($this->owner->$fieldName, '#'));
        }
    }
}
