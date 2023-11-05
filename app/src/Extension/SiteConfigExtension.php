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
        $fields->addFieldToTab('Root.Theme', HeaderField::create('ColorsHeader', 'Colors'));
        $colors = $this->owner->config()->get('colors');
        foreach ($colors as $key => $color) {
            $colorField = ColorField::create($key, $color['title'])
                ->setDescription($color['description'])
                ->setRightTitle("Default: {$color['default']}");
            $fields->addFieldToTab('Root.Theme', $colorField);
        }

        parent::updateCMSFields($fields);
    }

    public function ColorHex($name): ?string
    {
        $color = $this->owner->Color($name);
        if ($color) {
            return '#' . $color->__toString();
        }
        return null;
    }
    public function ColorRGBVals($name): ?string
    {
        $color = $this->owner->Color($name);
        if ($color) {
            return "{$color->Red()}, {$color->Green()}, {$color->Blue()}";
        }
        return null;
    }

    public function Color($name): ?Color
    {
        $fieldName = $name . 'Color';
        if ($this->owner->hasField($fieldName)) {
            return DBField::create_field('Color', ltrim($this->owner->$fieldName, '#'));
        } else {
            switch ($name) {
                // *-text-emphasis
                case 'PrimaryTextEmphasis': 
                    return $this->owner->Color('Primary')->Blend(0.6, '#000000');
                case 'SecondaryTextEmphasis': 
                    return $this->owner->Color('Secondary')->Blend(0.6, '#000000');
                case 'SuccessTextEmphasis': 
                    return $this->owner->Color('Success')->Blend(0.6, '#000000');
                case 'InfoTextEmphasis': 
                    return $this->owner->Color('Info')->Blend(0.6, '#000000');
                case 'WarningTextEmphasis': 
                    return $this->owner->Color('Warning')->Blend(0.6, '#000000');
                case 'DangerTextEmphasis': 
                    return $this->owner->Color('Danger')->Blend(0.6, '#000000');
                case 'LightTextEmphasis': 
                    return $this->owner->Color('Dark')->Blend(0.6, '#000000');
                case 'DarkTextEmphasis': 
                    return $this->owner->Color('Dark')->Blend(0.6, '#000000');

                // *-bg-subtle
                case 'PrimaryBgSubtle': 
                    return $this->owner->Color('Primary')->Blend(0.8, '#ffffff');
                case 'SecondaryBgSubtle': 
                    return $this->owner->Color('Secondary')->Blend(0.8, '#ffffff');
                case 'SuccessBgSubtle': 
                    return $this->owner->Color('Success')->Blend(0.8, '#ffffff');
                case 'InfoBgSubtle': 
                    return $this->owner->Color('Info')->Blend(0.8, '#ffffff');
                case 'WarningBgSubtle': 
                    return $this->owner->Color('Warning')->Blend(0.8, '#ffffff');
                case 'DangerBgSubtle': 
                    return $this->owner->Color('Danger')->Blend(0.8, '#ffffff');
                case 'LightBgSubtle': 
                    return DBField::create_field('Color', 'cfcfd');
                case 'DarkBgSubtle': 
                    return DBField::create_field('Color', 'ed4da');
                
                // *-border-subtle
                case 'PrimaryBorderSubtle': 
                    return $this->owner->Color('Primary')->Blend(0.6, '#ffffff');
                case 'SecondaryBorderSubtle': 
                    return $this->owner->Color('Secondary')->Blend(0.6, '#ffffff');
                case 'SuccessBorderSubtle': 
                    return $this->owner->Color('Success')->Blend(0.6, '#ffffff');
                case 'InfoBorderSubtle': 
                    return $this->owner->Color('Info')->Blend(0.6, '#ffffff');
                case 'WarningBorderSubtle': 
                    return $this->owner->Color('Warning')->Blend(0.6, '#ffffff');
                case 'DangerBorderSubtle': 
                    return $this->owner->Color('Danger')->Blend(0.6, '#ffffff');
                case 'LightBorderSubtle': 
                    return DBField::create_field('Color', 'e9ecef');
                case 'DarkBorderSubtle': 
                    return DBField::create_field('Color', 'db5bd');

                // other
                case 'SecondaryColor':
                    return $this->owner->Color('Dark')->Blend(0.25, '#ffffff');
                case 'SecondaryBg':
                    return DBField::create_field('Color', 'e9ecef');
                case 'TertiaryColor':
                    return $this->owner->Color('Dark')->Blend(0.5, '#ffffff');
                case 'TertiaryBg':
                    return DBField::create_field('Color', 'f8f9fa');
                case 'BodyColor':
                    return $this->owner->Color('Dark');

                case 'White':
                    return DBField::create_field('Color', 'ffffff');
                case 'Black':
                    return DBField::create_field('Color', '000000');
            }
        }
        return null;
    }
}
