<?php
namespace QI\App\Model;

use gorriecoe\Link\Models\Link;
use Jawira\CaseConverter\Convert;
use Page;
use QI\App\Lib\ColorHelpers;
use QI\App\Lib\LiteralFieldWrapper;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\File;
use SilverStripe\Dev\Debug;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\View\Requirements;
use SilverStripe\View\SSViewer;

/**
 * Class \QI\App\Model\FooterLink
 *
 * @property string $IconClass
 * @property int $Sort
 * @property bool $HideTitle
 * @property int $IconFileID
 * @property int $SiteConfigID
 * @method \SilverStripe\Assets\File IconFile()
 * @method \SilverStripe\SiteConfig\SiteConfig SiteConfig()
 */
class FooterLink extends Link
{
    private static $db = [
        'IconClass' => 'Varchar(32)',
        'Sort'      => 'Int',
        'HideTitle' => 'Boolean',
    ];
    private static $default_sort = 'Sort ASC';
    private static $has_one = [
        'IconFile'   => File::class,
        'SiteConfig' => SiteConfig::class,
    ];
    private static $owns = [
        'IconFile',
    ];
    private static $summary_fields = [
        'CMSPreview' => 'Preview',
    ];
    private static $table_name = 'FooterLink';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        // HideTitle
        $fields->insertAfter('Title', CheckboxField::create('HideTitle')->setDescription('If checked, the title will still show up as an attribute on the link for accessibility'));

        // IconClass
        $iconClasses = Page::config()->get('bootstrap_icons');
        $iconsArray = array_combine($iconClasses, $iconClasses);
        $iconClass = DropdownField::create('IconClass', 'Icon Class', $iconsArray);
        $iconClass->setEmptyString('- none -');
        $fields->addFieldToTab('Root.Main', $iconClass);

        // IconFile
        $iconFile = UploadField::create('IconFile', 'Icon File');
        $iconFile->setFolderName('Footer-Icons');
        $iconFile->setAllowedExtensions(['jpg', 'jpeg', 'png', 'gif', 'svg']);
        $iconFile->displayIf('IconClass')->isEmpty();
        $fields->addFieldToTab('Root.Main', $iconFile);
        
        // Preview
        $preview = LiteralFieldWrapper::create('FooterLinkPreview', 'Preview', $this->getCMSPreview());
        $fields->addFieldToTab('Root.Main', $preview);
        
        return $fields;
    }

    public function getCMSPreview() {
        Requirements::css('/_resources/themes/main/dist/css/icons.css');
        $siteConfig = SiteConfig::current_site_config();
        $bg = $siteConfig->FooterBg;
        $convert = new Convert($bg);
        $bgColorName = $convert->fromLower()->toTitle();
        $bgColor = ColorHelpers::color($bgColorName);
        return DBField::create_field('HTMLText', "<div class='px-3 py-1' style='background-color: #{$bgColor};'>{$this->forTemplate()}</div>");
    }

    /**
     * Renders an HTML anchor attribute for this link
     * @return \SilverStripe\ORM\FieldType\DBHTMLText
     */
    public function forTemplate()
    {
        $link = '';
        $themes = SSViewer::get_themes();
        SSViewer::set_themes(['silverstripe/admin:cms-forms', 'main', '$default']);
        $this->addExtraClass($this->getLinkColor()->CssClass);
        if ($this->LinkURL) {
            $link = $this->renderWith($this->getViewerTemplates());
        }
        $this->extend('updateTemplate', $link);
        SSViewer::set_themes($themes, ['main']);
        return $link;
    }

    public function getLinkColor() {
        $siteConfig = SiteConfig::current_site_config();
        $bg = $siteConfig->FooterBg;
        $convert = new Convert($bg);
        $bgColorName = $convert->fromLower()->toTitle();
        $white = '#ffffff';
        $black = '#000000';
        $options = [
            'primary' => $siteConfig->PrimaryColor,
            'white' => $white,
            'black' => $black,
        ];
        $color = ColorHelpers::contrasting_text($bgColorName, $options);
        return $color;
    }

}
