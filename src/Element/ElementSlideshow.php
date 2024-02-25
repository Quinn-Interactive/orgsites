<?php

namespace QuinnInteractive\Orgsite\Element;

use DNADesign\Elemental\Models\ElementContent;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldConfig;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use TractorCow\Fluent\Forms\VisibleLocalesColumn;

/**
 * Class \QuinnInteractive\Orgsite\Element\ElementVideoCarousel
 *
 * @property bool $Slider
 * @method \SilverStripe\ORM\DataList|\QuinnInteractive\Orgsite\Model\GalleryItem[] GalleryItems()
 */
class ElementSlideshow extends ElementContent
{
    private static $aspect_ratios = [
        '16:9' => ['title' => '16:9 - HD video', 'ratio' => 16 / 9],
        '5:4'  => ['title' => '5:4 - Old computer displays', 'ratio' => 5 / 4],
        '4:3'  => ['title' => '4:3 - SDTV (pre-HD Television)', 'ratio' => 4 / 3],
        '3:2'  => ['title' => '3:2 - 35mm film, DSLR Cameras, some older smartphones', 'ratio' => 3 / 2],
        '1:1'  => ['title' => '1:1 - Square', 'ratio' => 1 / 1],
        '9:16' => ['title' => '9:16 - Vertical video from a smartphone', 'ratio' => 9 / 16],
    ];
    private static $db = [
        'AspectRatio' => 'Varchar(8)',
        'Autoplay'    => 'Boolean',
        'FullWidth'   => 'Boolean',
    ];
    private static $defaults = [
        'AspectRatio' => '16:9',
        'Autoplay'    => true,
    ];
    private static $has_many = [
        'Slides' => Slide::class,
    ];
    private static $icon = 'font-icon-block-carousel';
    private static $inline_editable = false;
    private static $owns = [
        'Slides',
    ];
    private static $table_name = 'ElementSlideshow';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        // Slides
        /** @var GridField $slides */
        $slides = $fields->dataFieldByName('Slides');
        if ($slides) {
            /** @var GridFieldConfig $config */
            $config = $slides->getConfig();
            $config->addComponent(new GridFieldOrderableRows('Sort'));
            $config->removeComponentsByType(GridFieldAddExistingAutocompleter::class);
            $config->addComponent(new VisibleLocalesColumn());
            $fields->removeByName('Slides');
            $fields->addFieldToTab('Root.Main', $slides);
        }

        // AspectRatio
        $aspect_ratios = $this->config()->get('aspect_ratios');
        $ratios = [];
        foreach ($aspect_ratios as $key => $value) {
            $ratios[$key] = $value['title'];
        }
        $aspectRatio = DropdownField::create('AspectRatio', 'Aspect Ratio', $ratios);
        $aspectRatio->setDescription('Crop images to this ratio.');
        $fields->removeByName('AspectRatio');
        $fields->insertAfter('HTML', $aspectRatio);

        // Autoplay
        $autoplay = $fields->dataFieldByName('Autoplay');
        $autoplay->setDescription('Automatically play slideshow.');

        // FullWidth
        $fullWidth = $fields->dataFieldByName('FullWidth');
        $fullWidth->setDescription('Show slides full browser window width?');

        return $fields;
    }

    public function getRatioPercentage(): string
    {
        $aspect_ratios = $this->config()->get('aspect_ratios');
        $ratio = $aspect_ratios[$this->AspectRatio]['ratio'];
        return (100 * (1 / $ratio)) . '%';
    }
    public function getShowArrows(): bool
    {
        if ($this->Slides()->filterAny(['Caption:GreaterThan' => '', 'ShowTitle' => true])->Count()
            || $this->Slides()->filter(['LinkID:GreaterThan' => 0, 'HideButton' => false])->Count()) {
            return false;
        }
        return true;
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Slideshow');
    }

    public function onBeforeWrite()
    {
        parent::onBeforeWrite();
        // make sure Slides are sorted
        $slides = $this->Slides();
        if ($slides->Count()) {
            $sorts = $slides->column('Sort');
            if (count($sorts) != count(array_unique($sorts))) {
                $newsort = 1;
                foreach ($slides->Sort('Sort') as $slide) {
                    if ($newsort != $slide->Sort) {
                        $slide->Sort = $newsort;
                        $slide->write();
                    }
                    $newsort++;
                }
            }
        }
    }
}
