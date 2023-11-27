<?php
namespace QI\App\Model;

use DNADesign\Elemental\Forms\TextCheckboxGroupField;
use QI\App\Element\ElementGallery;
use QI\App\Extension\VideoExtension;
use QI\App\Lib\LiteralFieldWrapper;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\Versioned\Versioned;
use TractorCow\Fluent\Extension\FluentVersionedExtension;

/**
 * Class \QI\App\Model\GalleryItem
 *
 * @property string $VideoTitle
 * @property string $VideoURL
 * @property bool $VideoAutoPlay
 * @property int $Version
 * @property string $Title
 * @property string $Caption
 * @property int $Sort
 * @property int $VideoPreviewImageID
 * @property int $ElementGalleryID
 * @property int $ImageID
 * @method \SilverStripe\Assets\Image VideoPreviewImage()
 * @method \QI\App\Element\ElementGallery ElementGallery()
 * @method \SilverStripe\Assets\Image Image()
 * @mixin \SilverStripe\Versioned\Versioned
 * @mixin \QI\App\Extension\VideoExtension
 * @mixin \TractorCow\Fluent\Extension\FluentVersionedExtension
 */
class GalleryItem extends DataObject
{
    private static $db = [
        'Title'   => 'Varchar(128)',
        'Caption' => 'HTMLText',
        'Sort'    => 'Int',
    ];

    private static $default_sort = 'Sort ASC';
    private static $extensions = [
        Versioned::class,
        VideoExtension::class,
        FluentVersionedExtension::class,
    ];
    private static $has_one = [
        'ElementGallery' => ElementGallery::class,
        'Image'          => Image::class,
    ];
    private static $owns = [
        'Image',
    ];
    private static $summary_fields = [
        'ImageThumbnail' => 'Image',
        'Title',
        'VideoURL',
    ];
    private static $table_name = 'GalleryItem';
    private static $translate = [
        'Title',
        'Caption',
    ];
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        // Title
        $fields->replaceField(
            'Title',
            TextCheckboxGroupField::create()
                ->setName('Title')
        );
        $title = $fields->fieldByName('Root.Main.Title');
        $this->owner->updateFluentCMSField($title);

        $fields->dataFieldByName('Image')->setDescription('Image or video preview');

        $videoURL = $fields->dataFieldByName('VideoURL');
        $videoURL->setDescription('Optional. ' . $videoURL->getDescription());
        $fields->removeByName(['Sort', 'VideoTitle', 'VideoAutoPlay', 'VideoPreviewImage', 'ElementGalleryID', 'Video', 'Content']);
        $fields->addFieldToTab('Root.Main', $videoURL);

        // set up video service preview
        $videoServicePreview = null;
        if (!$this->Image()->exists()
            && ($this->VideoSource() == 'Vimeo' || $this->VideoSource() == 'YouTube')) {
            $videoServicePreview = $this->VideoThumbIMG('m') . '<br />Preview pulled from ' . $this->VideoSource();
            $fields->addFieldToTab('Root.Main', LiteralFieldWrapper::create('VideoServicePreview', 'Video Thumbnail', $videoServicePreview));
        }

        return $fields;
    }

    public function getImageThumbnail() {
        if ($this->Image()->exists()) {
            return $this->Image()->FitMax(120,90);
        }
        if ($this->owner->VideoSource() == 'Vimeo' || $this->owner->VideoSource() == 'YouTube') {
            return DBField::create_field('HTMLText', $this->VideoThumbIMG('s'));
        }
        return null;
    }

    public function getLink() {
        switch ($this->getItemType()) {
            case 'video':
                return $this->VideoURL;            
            case 'image':
                return $this->Image()->getURL();            
        }
        return null;
    }

    public function getItemType() {
        if ($this->VideoURL && ($this->IsYouTube() || $this->IsVimeo())) {
            return 'video';
        } else if ($this->Image()->exists()) {
            return 'image';
        }
        return 'unknown';
    }
}
