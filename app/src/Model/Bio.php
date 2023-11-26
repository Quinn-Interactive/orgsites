<?php

namespace QI\App\Model;

use QI\App\Element\ElementBios;
use SilverStripe\Assets\Image;
use SilverStripe\Assets\Storage\AssetContainer;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Security\Permission;
use SilverStripe\Versioned\Versioned;
use SilverStripe\View\Parsers\URLSegmentFilter;
use TractorCow\Fluent\Extension\FluentVersionedExtension;

/**
 * Class \QI\App\Model\Bio
 *
 * @property int $Version
 * @property string $Name
 * @property string $JobTitle
 * @property string $Summary
 * @property string $Content
 * @property int $ImageID
 * @method \SilverStripe\Assets\Image Image()
 * @method \SilverStripe\ORM\ManyManyList|\QI\App\Element\ElementBios[] ElementBios()
 * @mixin \SilverStripe\Versioned\Versioned
 * @mixin \TractorCow\Fluent\Extension\FluentVersionedExtension
 */
class Bio extends DataObject
{
    private static $belongs_many_many = [
        'ElementBios' => ElementBios::class,
    ];
    private static $db = [
        'Name'     => 'Varchar(128)',
        'JobTitle' => 'Varchar(128)',
        'Summary'  => 'Text',
        'Content'  => 'HTMLText',
    ];
    private static $extensions = [
        Versioned::class,
        FluentVersionedExtension::class,
    ];
    private static $has_one = [
        'Image' => Image::class,
    ];
    private static $owns = [
        'Image',
    ];
    private static $summary_fields = [
        'Name'           => 'Name',
        'JobTitle'       => 'Content',
        'GridFieldImage' => 'Image',
    ];
    private static $table_name = 'Bio';

    public function canCreate($member = null, $context = [])
    {
        return (bool) Permission::check(['CMS_ACCESS']);
    }

    public function canDelete($member = null, $context = [])
    {
        return $this->canCreate();
    }

    public function canEdit($member = null, $context = [])
    {
        return $this->canCreate();
    }

    public function canView($member = null, $context = [])
    {
        return true;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        // Image
        $image = $fields->dataFieldByName('Image');
        if ($image) {
            $image->setFolderName('Bio-Images');
            $fields->removeByName('Image');
            $fields->insertBefore('Summary', $image);
        }

        // Content
        $fields->dataFieldByName('Content');

        return $fields;
    }

    public function Slug(): string
    {
        $filter = URLSegmentFilter::create();
        return $filter->filter($this->Name);
    }

    protected function getGridFieldImage(): AssetContainer|DBHTMLText|null
    {
        if ($this->Image() && $this->Image()->exists()) {
            return $this->Image()->StripThumbnail();
        }
        return null;
    }
}
