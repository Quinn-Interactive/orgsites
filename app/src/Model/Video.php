<?php
namespace QI\App\Model;

use QI\App\Element\ElementVideoCarousel;
use QI\App\Extension\VideoExtension;
use SilverStripe\ORM\DataObject;
use SilverStripe\Versioned\Versioned;
use TractorCow\Fluent\Extension\FluentVersionedExtension;

/**
 * Class \QI\App\Model\Video
 *
 * @property string $VideoTitle
 * @property string $VideoURL
 * @property bool $VideoAutoPlay
 * @property int $Version
 * @property int $Sort
 * @property int $VideoPreviewImageID
 * @property int $ElementVideoCarouselID
 * @method \SilverStripe\Assets\Image VideoPreviewImage()
 * @method \QI\App\Element\ElementVideoCarousel ElementVideoCarousel()
 * @mixin \SilverStripe\Versioned\Versioned
 * @mixin \QI\App\Extension\VideoExtension
 * @mixin \TractorCow\Fluent\Extension\FluentVersionedExtension
 */
class Video extends DataObject
{
    private static $db = [
        'Sort' => 'Int',
    ];
    private static $extensions = [
        Versioned::class,
        VideoExtension::class,
        FluentVersionedExtension::class,
    ];
    private static $table_name = 'Video';
    private static $has_one = [
        'ElementVideoCarousel' => ElementVideoCarousel::class,
    ];
    private static $translate = [
        'HTML',
        'VideoTitle',
        'VideoURL',
        'VideoPreviewImageID'
    ];
    private static $default_sort = 'Sort ASC';
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName(['Sort', 'ElementVideoCarouselID']);        
        return $fields;
    }
}
