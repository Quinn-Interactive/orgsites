<?php

namespace QI\App\Extension;

use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\File;
use SilverStripe\Forms\FieldList;
use TractorCow\Fluent\Extension\FluentExtension;

/**
 * Class \QI\App\Extension\SiteConfigExtension
 *
 * @property \SilverStripe\SiteConfig\SiteConfig|\QI\App\Extension\SiteConfigExtension $owner
 * @property int $LogoID
 * @method \SilverStripe\Assets\File Logo()
 */
class SiteConfigExtension extends FluentExtension
{
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
        $logoField->setAllowedExtensions(['png', 'jpg', 'gif', 'svg']);
        $fields->addFieldToTab('Root.Main', $logoField);

        parent::updateCMSFields($fields);
    }

}
