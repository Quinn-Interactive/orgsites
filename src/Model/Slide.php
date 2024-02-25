<?php

namespace QuinnInteractive\Orgsite\Element;

use DNADesign\Elemental\Forms\TextCheckboxGroupField;
use gorriecoe\Link\Models\Link;
use gorriecoe\LinkField\LinkField;
use Page;
use QuinnInteractive\Orgsite\Lib\Helpers;
use SilverStripe\Assets\Image;
use SilverStripe\Assets\Storage\DBFile;
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

    private static $db = [
        'Title'        => 'Varchar(128)',
        'ShowTitle'    => 'Boolean',
        'TextPosition' => "Enum('top,bottom,right,left,center', 'bottom')",
        'TextColor'    => "Enum('white,black', 'white')",
        'Caption'      => 'HTMLText',
        'HideButton'   => 'Boolean',
        'Sort'         => 'Int',
    ];
    private static $default_sort = 'Sort';
    // private static $inline_editable = false;
    private static $disable_background_color = true;
    private static $extensions = [
        Versioned::class,
        FluentVersionedExtension::class,
    ];
    private static $has_one = [
        'Slideshow' => ElementSlideshow::class,
        'Image'     => Image::class,
        'Link'      => Link::class,
    ];

    private static $owns = [
        'Image',
    ];
    private static $summary_fields = [
        'ImageThumb',
        'ShowTitle',
        'TextPosition',
        'TextColor',
    ];
    private static $table_name = 'Slide';

    private static $translate = [
        'HTML',
    ];

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
        if (!$this->Slideshow()->exists()) {
            return $image;
        }
        $ratios = ElementSlideshow::config()->get('aspect_ratios');
        $parentRatio = $this->Slideshow()->AspectRatio;
        $ratio = $ratios[$parentRatio]['ratio'] ?? 16 / 9; // default to 16:9
        $scaled = $image->FocusFillMax($width, round($width / $ratio));
        return $scaled;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName(['Sort', 'SlideshowID']);

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
        $caption
            ->setRows(5)
            ->setTargetLength(300)
            ->setDescription(_t(Page::class . '.OPTIONAL', 'Optional'));

        // Image
        $image = $fields->dataFieldByName('Image')
            ->setFolderName('Slide-Images')
            ->setDescription(_t(self::class . '.Image_Description', 'Use Focus point to make sure focus area stays in frame.'));
        $fields->insertBefore('TextPosition', $image);

        // Link
        $fields->replaceField('LinkID', LinkField::create('Link', 'Link', $this)->setDescription('Optional'));

        // HideButton
        $hideButton = $fields->dataFieldByName('HideButton');
        $fields->insertAfter('Link', $hideButton);
        $hideButton->setDescription('Hide button (if Link set) and make whole slide link.');

        return $fields;
    }

    public function getContentClasses(): string
    {
        $classes = ['d-flex flex-column'];
        // top,bottom,right,left,center
        switch ($this->TextPosition) {
            case 'top':
                $classes[] = 'justify-content-start';
                break;
            case 'bottom':
                $classes[] = 'justify-content-end';
                break;
            case 'left':
                $classes[] = 'justify-content-center';
                $classes[] = 'align-items-start';
                $classes[] = 'text-start';
                $classes[] = 'w-md-50';
                break;
            case 'right':
                $classes[] = 'justify-content-center';
                $classes[] = 'align-items-end';
                $classes[] = 'text-start';
                $classes[] = 'w-md-50';
                break;
            case 'center':
                $classes[] = 'justify-content-center';
                $classes[] = 'align-items-center';
                break;

            default:
                break;
        }
        return join(' ', $classes);
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
}
