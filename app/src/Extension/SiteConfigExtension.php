<?php

namespace QI\App\Extension;

use Jawira\CaseConverter\Convert;
use QI\App\Lib\ColorHelpers;
use QI\App\Lib\LiteralFieldWrapper;
use RyanPotter\SilverStripeColorField\Forms\ColorField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\File;
use SilverStripe\Dev\Debug;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\View\ArrayData;
use TractorCow\Colorpicker\Color;
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
 * @property string $NavbarBg
 * @property string $BodyFont
 * @property string $HeadlineFont
 * @property string $MonospaceFont
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
        'NavbarBg'       => "Enum('primary, secondary, dark, light, white, black', 'primary')",
        'BodyFont'       => 'Varchar',
        'HeadlineFont'   => 'Varchar',
        'MonospaceFont'  => 'Varchar',
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
        'NavbarBg'       => 'primary',
        'BodyFont'       => 'native-sans-serif',
        'HeadlineFont'   => 'native-sans-serif',
        'MonospaceFont'  => 'native-monospace',
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

    public function Color($name): ?Color
    {
        return ColorHelpers::color($name);
    }

    public function ColorHex($name): ?string
    {
        return ColorHelpers::color_hex($name);
    }
    public function ColorRGBVals($name): ?string
    {
        return ColorHelpers::color_rgb_vals($name);
    }

    public function getNavbarTextColor(): ArrayData
    {
        $navbarBg = $this->owner->NavbarBg;
        $convert = new Convert("{$navbarBg}");
        $navbarColorField = $convert->fromKebab()->toPascal();
        $result = ColorHelpers::contrasting_text($navbarColorField);
        if (in_array($result->CssClass, ['text-light', 'text-white'])) {
            $result->NavbarBGClass = 'navbar-dark';
            $result->BtnCloseClass = 'btn-close-white';
        } else {
            $result->NavbarBGClass = 'navbar-light';
            $result->BtnCloseClass = 'btn-close-black';
        }
        return $result;
    }

    public function onBeforeWrite(): void
    {
        $colors = $this->owner->config()->get('colors');
        foreach ($colors as $field => $value) {
            $test = ltrim($this->owner->$field, '#');
            if (!ctype_xdigit(strtoupper($test)) || strlen($test) != 6) {
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
        $fields->addFieldToTab('Root.Theme.Colors', HeaderField::create('ColorsHeader', 'Colors'));
        $colors = $this->owner->config()->get('colors');
        foreach ($colors as $key => $color) {
            $colorField = ColorField::create($key, $color['title'])
                ->setDescription($color['description'])
                ->setRightTitle("Default: {$color['default']}");
            $fields->addFieldToTab('Root.Theme.Colors', $colorField);
        }

        // NavbarBg
        $navColors = $this->owner->dbObject('NavbarBg')->enumValues();
        $fields->addFieldToTab('Root.Theme.Colors', $navbarBg = DropdownField::create('NavbarBg', 'Navigation Background Color', $navColors));
        $navbarBg->setDescription('Accessibility contrast rating: ' . $this->owner->getNavbarTextColor()->Rating);

        // Type
        $fields->addFieldToTab('Root.Theme.Type', HeaderField::create('TypeHeader', 'Typography'));

        // Fonts
        $fonts = $this->owner->config()->get('fonts');
        $bodyFonts = [];
        $headlineFonts = [];
        $monospaceFonts = [];
        foreach ($fonts as $key => $font) {
            $title = $font['title'];
            $uses = $font['uses'];
            if (in_array('body', $uses)) {
                $bodyFonts[$key] = $title;
            }
            if (in_array('headline', $uses)) {
                $headlineFonts[$key] = $title;
            }
            if (in_array('monospace', $uses)) {
                $monospaceFonts[$key] = $title;
            }
        }
        $fields->addFieldToTab('Root.Theme.Type', DropdownField::create('BodyFont', 'Body Font', $bodyFonts)
            ->setDescription('Will be used for most text on site.')
        );
        $fields->addFieldToTab('Root.Theme.Type', DropdownField::create('HeadlineFont', 'Headline Font', $headlineFonts)
            ->setDescription('Will be used for large headlines.')
        );
        $fields->addFieldToTab('Root.Theme.Type', DropdownField::create('MonospaceFont', 'Monospace Font', $monospaceFonts)
            ->setDescription('Will be used for code samples or when monospaced is required.')
        );
        // Type Sample
        $typeSamples = $this->owner->renderWith('TypeSamples');
        $fields->addFieldToTab('Root.Theme.Type', LiteralFieldWrapper::create('TypeSamples', 'Type Samples', $typeSamples));

        parent::updateCMSFields($fields);
    }

    public function getFont($key): ?array
    {
        $fonts = $this->owner->config()->get('fonts');
        $font = $fonts[$key] ?? null;
        return $font;
    }

    public function FontData($name): ?ArrayData
    {
        $field = "{$name}Font";
        $font = $this->owner->getFont($this->owner->$field);
        if (!$font) {
            return null;
        }
        return ArrayData::create($font);
    }

    public function getFontHeadCode(): string
    {
        $code = [];
        $bodyFont = $this->owner->getFont($this->owner->BodyFont);
        $headlineFont = $this->owner->getFont($this->owner->HeadlineFont);
        $monospaceFont = $this->owner->getFont($this->owner->MonospaceFont);
        foreach ([$bodyFont, $headlineFont, $monospaceFont] as $font) {
            $link = $font['link'] ?? null;
            if ($link) {
                $code[] = "<link href=\"$link\" rel=\"stylesheet\">";
            }
        }
        if (count($code)) {
            array_unshift($code, '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>');
            array_unshift($code, '<link rel="preconnect" href="https://fonts.googleapis.com">');
        }
        return join("\n", $code);
    }
}
