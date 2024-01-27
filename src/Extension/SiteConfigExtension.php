<?php

namespace QuinnInteractive\Orgsite\Extension;

use Jawira\CaseConverter\Convert;
use QuinnInteractive\Orgsite\Lib\ColorHelpers;
use QuinnInteractive\Orgsite\Lib\LiteralFieldWrapper;
use QuinnInteractive\Orgsite\Model\FooterLink;
use RyanPotter\SilverStripeColorField\Forms\ColorField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;
use SilverStripe\View\SSViewer;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use TractorCow\Colorpicker\Color;
use TractorCow\Fluent\Extension\FluentExtension;
use TractorCow\Fluent\Forms\VisibleLocalesColumn;

/**
 * Class \QuinnInteractive\Orgsite\Extension\SiteConfigExtension
 *
 * uses:
 * - data type: https://github.com/tractorcow/silverstripe-colorpicker
 * - edit field: https://github.com/Rhym/silverstripe-color-field
 *
 * @property \SilverStripe\SiteConfig\SiteConfig|\QuinnInteractive\Orgsite\Extension\SiteConfigExtension $owner
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
 * @property string $Footer
 * @property string $FooterBg
 * @property int $LogoID
 * @method \SilverStripe\Assets\File Logo()
 * @method \SilverStripe\ORM\DataList|\QuinnInteractive\Orgsite\Model\FooterLink[] FooterLinks()
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
        'Footer'         => 'HTMLText',
        'FooterBg'       => "Enum('primary, secondary, dark, light, white, black', 'primary')",
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
    private static $has_many = [
        'FooterLinks' => FooterLink::class,
    ];

    private static $has_one = [
        'Logo' => File::class,
        'FaviconSmall'   => Image::class,
        'FaviconLarge'   => Image::class,
    ];
    private static $owns = [
        'Logo',
        'FaviconSmall',
        'FaviconLarge',
    ];
    private static $translate = [
        'Title',
        'Tagline',
        'Footer',
    ];
    public function AllFontsHeadCode($type = 'link'): string
    {
        $code = [];
        $fonts = $this->owner->config()->get('fonts');
        $keys = array_keys($fonts);
        $link = $this->owner->makeGoogleFontsLink($keys);
        if ($link) {
            if ($type == 'import') {
                $code[] = "@import url('{$link}');";
            } else {
                $code[] = '<link rel="preconnect" href="https://fonts.googleapis.com">';
                $code[] = '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
                $code[] = "<link href=\"{$link}\" rel=\"stylesheet\">";
            }
        }
        // Debug::dump($code); die;
        return join("\n", $code);
    }

    public function AvailableFonts(): ArrayList
    {
        $fonts = $this->owner->config()->get('fonts');
        $list = ArrayList::create();
        foreach ($fonts as $font) {
            $list->push(ArrayData::create([
                'Title'    => $font['title'],
                'Family'   => $font['family'],
                'Styles'   => join(', ', $font['styles'] ?? []),
                'Weights'  => join(', ', $font['weights'] ?? []),
                'Category' => $font['category'],
                'Uses'     => join(', ', $font['uses'] ?? []),
            ]));
        }
        return $list;
    }

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

    public function FontData($name): ?ArrayData
    {
        $field = "{$name}Font";
        $font = $this->owner->getFont($this->owner->$field);
        if (!$font) {
            return null;
        }
        return ArrayData::create($font);
    }

    public function FontHeadCode($type = 'link'): string
    {
        $code = [];
        $link = $this->owner->makeGoogleFontsLink([$this->owner->BodyFont, $this->owner->HeadlineFont, $this->owner->MonospaceFont]);
        if ($link) {
            if ($type == 'import') {
                $code[] = "@import url('{$link}');";
            } else {
                $code[] = '<link rel="preconnect" href="https://fonts.googleapis.com">';
                $code[] = '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
                $code[] = "<link href=\"{$link}\" rel=\"stylesheet\">";
            }
        }
        // Debug::dump($code); die;
        return join("\n", $code);
    }

    public function getFont($key): ?array
    {
        $fonts = $this->owner->config()->get('fonts');
        $font = $fonts[$key] ?? null;
        return $font;
    }

    public function getFooterTextColor(): ArrayData
    {
        $footerBg = $this->owner->FooterBg;
        $convert = new Convert("{$footerBg}");
        $footerColorField = $convert->fromKebab()->toPascal();
        $result = ColorHelpers::contrasting_text($footerColorField);
        if (in_array($result->CssClass, ['text-light', 'text-white'])) {
            $result->FooterBGClass = 'navbar-dark';
        } else {
            $result->FooterBGClass = 'navbar-light';
        }
        return $result;
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

    public function makeGoogleFontsLink($keys): ?string
    {
        $link = null;
        $google = false;
        $families = [];
        foreach ($keys as $key) {
            $font = $this->owner->getFont($key);
            $source = $font['source'] ?? null;
            if ($source != 'google') {
                continue;
            }
            $google = true;
            $string = urlencode($font['title']) . ':';
            $styles = $font['styles'];
            $weights = $font['weights'];
            $hasItalic = in_array('italic', $styles);
            if ($hasItalic) {
                $string .= 'ital,';
            }
            $weightParts = [];
            foreach ($weights as $weight) {
                if ($hasItalic) {
                    $weightParts[] = "0,{$weight}";
                } else {
                    $weightParts[] = $weight;
                }
            }
            if ($hasItalic) {
                foreach ($weights as $weight) {
                    $weightParts[] = "1,{$weight}";
                }
            }
            $string .= 'wght@' . join(';', $weightParts);

            $families[] = "family={$string}";
        }
        if ($google) {
            $families = join('&', $families);
            // https://fonts.googleapis.com/css2?family=Playfair+Display:ital@0;1&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;1,500&display=swap
            $link = "https://fonts.googleapis.com/css2?{$families}&display=swap";
        }
        return $link;
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
        $fields->addFieldToTab('Root.Logos', $logoField);

        // FaviconLarge
        $faviconLarge = UploadField::create('FaviconLarge', 'Favicon Large');
        $faviconLarge->setAllowedExtensions(['png', 'jpg'])
        ->setDescription('Large PNG or JPEG file. Ideally 600x600. This icon will be used for other app icons.')
        ->setFolderName('Favicons');
        $fields->addFieldToTab('Root.Logos', $faviconLarge);

        // FaviconSmall
        $faviconSmall = UploadField::create('FaviconSmall', 'Favicon Small');
        $faviconSmall->setAllowedExtensions(['png', 'jpg'])
            ->setDescription('Small PNG or JPEG file. Ideally 16x16px. This icon will be used as the browser tab icon.')
            ->setFolderName('Favicons');
        $fields->addFieldToTab('Root.Logos', $faviconSmall);

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
        $fields->addFieldToTab(
            'Root.Theme.Type',
            DropdownField::create('BodyFont', 'Body Font', $bodyFonts)
            ->setDescription('Will be used for most text on site.')
        );
        $fields->addFieldToTab(
            'Root.Theme.Type',
            DropdownField::create('HeadlineFont', 'Headline Font', $headlineFonts)
            ->setDescription('Will be used for large headlines.')
        );
        $fields->addFieldToTab(
            'Root.Theme.Type',
            DropdownField::create('MonospaceFont', 'Monospace Font', $monospaceFonts)
            ->setDescription('Will be used for code samples or when monospaced is required.')
        );
        // Type Samples
        SSViewer::add_themes(['quinninteractive/orgsite:orgsite']);
        $typeSamples = $this->owner->renderWith('QuinnInteractive/Orgsite/TypeSamples');
        $fields->addFieldToTab('Root.Theme.Type', LiteralFieldWrapper::create('TypeSamples', 'Type Samples', $typeSamples));

        // Footer
        $footerColors = $this->owner->dbObject('NavbarBg')->enumValues();
        $fields->addFieldToTab('Root.Theme.Colors', $footerBg = DropdownField::create('FooterBg', 'Footer Background Color', $footerColors));
        $footerBg->setDescription('Accessibility contrast rating: ' . $this->owner->getFooterTextColor()->Rating);
        $fields->addFieldToTab('Root.Main', HTMLEditorField::create('Footer', 'Footer Text'));

        // FooterLinks
        $config = GridFieldConfig_RelationEditor::create();
        $config->addComponent(GridFieldOrderableRows::create('Sort'));
        $config->removeComponentsByType(GridFieldAddExistingAutocompleter::class);
        $config->removeComponentsByType(GridFieldDeleteAction::class);
        $config->addComponent(GridFieldDeleteAction::create());
        $footerLinks = GridField::create('FooterLinks', 'Footer Links', $this->owner->FooterLinks(), $config);
        $fields->addFieldToTab('Root.Main', $footerLinks);

        parent::updateCMSFields($fields);
    }

    public function FaviconSmallOrLogo(): ?Image
    {
        if ($this->owner->FaviconSmall()->exists()) {
            return $this->owner->FaviconSmall();
        }
        if ($this->owner->FaviconLarge()->exists()) {
            return $this->owner->FaviconLarge();
        }
        if ($this->owner->Logo()->exists() && $this->owner->Logo()->getIsImage()) {
            return $this->owner->Logo();
        }
        return null;
    }
    public function FaviconLargeOrLogo(): ?Image
    {
        if ($this->owner->FaviconLarge()->exists()) {
            return $this->owner->FaviconLarge();
        }
        if ($this->owner->FaviconSmall()->exists()) {
            return $this->owner->FaviconSmall();
        }
        if ($this->owner->Logo()->exists() && $this->owner->Logo()->getIsImage()) {
            return $this->owner->Logo();
        }
        return null;
    }
}
