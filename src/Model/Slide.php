<?php

namespace QuinnInteractive\Orgsite\Element;

use DNADesign\Elemental\Forms\TextCheckboxGroupField;
use DNADesign\Elemental\Models\ElementContent;
use gorriecoe\Link\Models\Link;
use gorriecoe\LinkField\LinkField;
use Page;
use QuinnInteractive\Orgsite\Lib\Helpers;
use SilverStripe\Assets\Image;
use SilverStripe\Assets\Storage\DBFile;
use SilverStripe\Dev\Debug;
use SilverStripe\Forms\TextareaField;
use SilverStripe\ORM\DataObject;
use SilverStripe\Versioned\Versioned;
use TractorCow\Fluent\Extension\FluentVersionedExtension;

/**
 * Class \QuinnInteractive\Orgsite\Element\ElementBanner
 *
 * @property string $TextPosition
 * @property string $TextColor
 * @property int $ImageID
 * @method \SilverStripe\Assets\Image Image()
 */
class Slide extends DataObject
{
    private static $default_sort = 'Sort';
    private static $extensions = [
        Versioned::class,
        FluentVersionedExtension::class,
    ];

    private static $db = [
        'Title'     => 'Varchar(128)',
        'ShowTitle' => 'Boolean',
        'TextPosition' => "Enum('top,bottom,right,left,center', 'bottom')",
        'TextColor'    => "Enum('white,black', 'white')",
        'Caption'   => 'Text',
        'Sort'      => 'Int',
    ];
    // private static $inline_editable = false;
    private static $disable_background_color = true;
    private static $has_one = [
        'Slideshow' => ElementSlideshow::class,
        'Image' => Image::class,
        'Link'   => Link::class,
    ];

    private static $owns = [
        'Image',
    ];
    private static $table_name = 'Slide';

    private static $translate = [
        'HTML',
    ];
    private static $summary_fields = [
        'ImageThumb',
        'ShowTitle',
        'TextPosition',
        'TextColor',
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('Sort');

        // Title
        $fields->removeByName('ShowTitle');
        $fields->replaceField(
            'Title',
            TextCheckboxGroupField::create()
                ->setName('Title')
        );
        $title = $fields->fieldByName('Root.Main.Title');
        $this->owner->updateFluentCMSField($title);        

        // TextPosition
        Helpers::localize_select($fields->dataFieldByName('TextPosition'), $this);

        // Caption
        /** @var TextareaField $caption **/
        $caption = $fields->dataFieldByName('Caption');
        $caption->setMaxLength(300)
            ->setDescription(_t(Page::class . '.OPTIONAL', 'Optional'));

        // Image
        $fields->dataFieldByName('Image')
            ->setFolderName('Slide-Images')
            ->setDescription(_t(self::class . '.Image_Description', 'Use Focus point to make sure focus area stays in frame.'));

        // Link
        $fields->replaceField('LinkID', LinkField::create('Link', 'Link', $this)->setRightTitle('Optional'));


        return $fields;
    }

    /**
     * override default style variant
     *
     * @return string
     */
    public function getStyleVariant()
    {
        $color = $this->TextColor;
        if ($color == 'white') {
            return 'text-bg-dark';
        }
        return 'text-bg-light';
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Banner');
    }

    public function getImageThumb(): ?DBFile
    {
        $image = $this->Image();
        if ($image->exists() && $image->getIsImage()) {
            return $image->StripThumbnail();
        }
        return null;
    }

    /**
     * For use in ElementSlideshow
     * @return ?DBFile
     */
    public function FocusRatioFill(int $width = 1024): ?DBFile
    {
        $image = $this->Image();
        if (!$image) {
            return null;
        }
        if (!$this->ElementSlideshow()->exists()) {
            return $image;
        }
        $ratios = ElementSlideshow::config()->get('aspect_ratios');
        $parentRatio = $this->ElementSlideshow()->AspectRatio;
        $ratio = $ratios[$parentRatio]['ratio'] ?? 16 / 9; // default to 16:9
        $scaled = $image->FocusFillMax($width, round($width / $ratio));
        return $scaled;
    }

    // /**
    //  * For use in ElementSlideshow
    //  * @return boolean
    //  */
    // public function SlideFirst()
    // {
    //     return ($this->ElementSlideshow()->Slides()->first()->ID === $this->ID);
    // }

    // /**
    //  * For use in ElementSlideshow
    //  * @return boolean
    //  */
    // public function SlideLast()
    // {
    //     return ($this->ElementSlideshow()->Slides()->last()->ID === $this->ID);
    // }

    // /**
    //  * For use in ElementSlideshow
    //  * @return int
    //  */
    // public function SlideTotalItems()
    // {
    //     return $this->ElementSlideshow()->Slides()->count();
    // }

    // /**
    //  * For use in ElementSlideshow
    //  * Returns the position of the current element.
    //  *
    //  * @return int
    //  */
    // public function SlidePos(int $root = 1)
    // {
    //     return ($this->ElementSlideshow()->Slides()->filter('Sort:LessThan', $this->Sort)->count() + $root);
    // }

    // /**
    //  * For use in ElementSlideshow
    //  * @return string
    //  */
    // public function SlideEvenOdd()
    // {
    //     $odd = (bool) ($this->Pos() % 2);

    //     return  ($odd) ? 'odd' : 'even';
    // }

}
