<?php

namespace QI\App\Model;

use QI\App\Page\BioIndex;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;
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
 * @property string $Content
 * @property int $Sort
 * @property int $BioIndexID
 * @property int $ImageID
 * @method \QI\App\Page\BioIndex BioIndex()
 * @method \SilverStripe\Assets\Image Image()
 * @mixin \SilverStripe\Versioned\Versioned
 * @mixin \TractorCow\Fluent\Extension\FluentVersionedExtension
 */
class Bio extends DataObject
{
    private static $db = [
        'Name'     => 'Varchar(128)',
        'JobTitle' => 'Varchar(128)',
        'Content'  => 'HTMLText',
        'Sort'     => 'Int',
    ];
    private static $default_sort = 'Sort';
    private static $extensions = [
        Versioned::class,
        FluentVersionedExtension::class,
    ];
    private static $has_one = [
        'BioIndex' => BioIndex::class,
        'Image'    => Image::class,
    ];
    private static $owns = [
        'Image',
    ];
    private static $summary_fields = [
        'Title'                => 'Title',
        'JobTitle'             => 'Content',
        'Image.StripThumbnail' => 'Image',
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

        $fields->removeByName(['Sort', 'BioIndexID']);

        // Image
        $image = $fields->dataFieldByName('Image');
        if ($image) {
            $image->setFolderName('Bio-Images');
        }

        return $fields;
    }

    public function Slug(): string
    {
        $filter = URLSegmentFilter::create();
        return $filter->filter($this->Name);
    }
}
