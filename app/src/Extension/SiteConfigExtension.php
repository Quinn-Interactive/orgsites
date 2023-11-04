<?php

namespace QI\App\Extension;

use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\File;
use SilverStripe\Core\Config\Config;
use SilverStripe\Dev\Debug;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HeaderField;
use TractorCow\Colorpicker\Color;
use TractorCow\Colorpicker\Forms\ColorField;
use TractorCow\Fluent\Extension\FluentExtension;

/**
 * Class \QI\App\Extension\SiteConfigExtension
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
    private static $colors = [
        'PrimaryColor'   => ['default' => '#0d6efd', 'title' => 'Primary Color', 'description' => 'Main theme color, used for hyperlinks, focus styles, and component and form active states.'],
        'SecondaryColor' => ['default' => '#6c757d', 'title' => 'Secondary Color', 'description' => 'Use the color option for lighter text. Use the bg option for dividers and to indicate disabled component states.'],
        'SuccessColor'   => ['default' => '#198754', 'title' => 'Success Color', 'description' => 'Theme color used for positive or successful actions and information.'],
        'DangerColor'    => ['default' => '#dc3545', 'title' => 'Danger Color', 'description' => 'Theme color used for errors and dangerous actions.'],
        'WarningColor'   => ['default' => '#ffc107', 'title' => 'Warning Color', 'description' => 'Theme color used for non-destructive warning messages.'],
        'InfoColor'      => ['default' => '#0dcaf0', 'title' => 'Info Color', 'description' => 'Theme color used for neutral and informative content.'],
        'LightColor'     => ['default' => '#f8f9fa', 'title' => 'Light Color', 'description' => 'Additional theme option for less contrasting colors.'],
        'DarkColor'      => ['default' => '#212529', 'title' => 'Dark Color', 'description' => 'Additional theme option for higher contrasting colors.'],
    ];
    private static $db = [
        'PrimaryColor'   => Color::class,
        'SecondaryColor' => Color::class,
        'SuccessColor'   => Color::class,
        'DangerColor'    => Color::class,
        'WarningColor'   => Color::class,
        'InfoColor'      => Color::class,
        'LightColor'     => Color::class,
        'DarkColor'      => Color::class,
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
                ->setDescription($color['description']);
            $fields->addFieldToTab('Root.Main', $colorField);
        }

        parent::updateCMSFields($fields);
    }
}
