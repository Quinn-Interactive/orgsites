<?php

namespace QuinnInteractive\Orgsite\Model;

use gorriecoe\Link\Models\Link;
use gorriecoe\LinkField\LinkField;
use QuinnInteractive\Orgsite\Element\ElementPromos;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\File;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\Versioned\Versioned;
use TractorCow\Fluent\Extension\FluentVersionedExtension;

/**
 * Class \QuinnInteractive\Orgsite\Model\Promo
 *
 * @property int $Version
 * @property string $Title
 * @property string $Content
 * @property bool $StretchedLink
 * @property int $Sort
 * @property int $ImageID
 * @property int $ParentID
 * @property int $LinkID
 * @method \SilverStripe\Assets\File Image()
 * @method \QuinnInteractive\Orgsite\Element\ElementPromos Parent()
 * @method \gorriecoe\Link\Models\Link Link()
 * @mixin \SilverStripe\Versioned\Versioned
 * @mixin \TractorCow\Fluent\Extension\FluentVersionedExtension
 */
class Promo extends DataObject
{

    private static $casting = [
        'DescriptionOrSummary' => 'HTMLText',
    ];

    private static $db = [
        'Title'   => 'Varchar(128)',
        'Content' => 'HTMLText',
        'Sort'    => 'Int',
    ];
    private static $default_sort = 'Sort';
    private static $extensions = [
        Versioned::class,
        FluentVersionedExtension::class,
    ];
    private static $has_one = [
        'Image'  => File::class,
        'Parent' => ElementPromos::class,
        'Link'   => Link::class,
    ];
    private static $owns = [
        'Image',
        'Link',
    ];
    private static $summary_fields = [
        'Thumbnail'    => 'Image',
        'Title'        => 'Title',
        'Link.LinkURL' => 'Link',
    ];
    private static $table_name = 'Promo';

    public function DescriptionOrSummary()
    {
        return $this->Content;
    }

    public function getButtonStyle(): string
    {
        return $this->Parent()->ButtonStyle ?? 'button';
    }

    public function getStretchedLink(): string
    {
        return $this->getButtonStyle() != 'button';
    }

    public function getHideButtonText(): string
    {
        return $this->getButtonStyle() == 'whole card' || $this->getHideText();
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName(['Sort', 'ParentID']);
        /** @var UploadField */
        $image = $fields->dataFieldByName('Image');
        if ($image) {
            $image->setTitle('Image or SVG')
                ->setFolderName('Promo-Images')
                ->setAllowedExtensions(['jpg', 'png', 'gif', 'svg']);
        }

        // Link
        $fields->replaceField('LinkID', LinkField::create('Link', 'Link', $this)->setRightTitle('Optional'));

        return $fields;
    }

    public function getHideImages(): bool
    {
        return $this->Parent()->HideImages ?? false;

    }

    public function getHideText(): bool
    {
        return $this->Parent()->HideText ?? false;
    }

    public function getThumbnail()
    {
        /** @var File */
        $image = $this->Image();
        if (!$image || !$image->exists()) {
            return null;
        }
        if ($image->getIsImage()) {
            return $image->StripThumbnail();
        }
        if ($image->getExtension() == 'svg') {
            return DBField::create_field('HTMLText', "<img src='{$image->getURL()}' width='50' height='50' />");
        }
    }
}
