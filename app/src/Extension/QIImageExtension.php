<?php

namespace QI\App\Extension;

use SilverStripe\Assets\Image;
use SilverStripe\Assets\Image_Backend;
use SilverStripe\ORM\DataExtension;

/**
 * QIImageExtension.php.
 *
 * @author Quinn Interactive, Inc.
 */

/**
 * StartGeneratedWithDataObjectAnnotator
 *
 * @property \SilverStripe\Assets\Image|\QI\App\Extension\QIImageExtension $owner
 */
class QIImageExtension extends DataExtension
{
    # added to make sure thumbnail shows up in UploadField
    private static $summary_fields = [
        'StripThumbnail' => 'Thumbnail',
        'Name' => 'Name',
        'Title' => 'Title',
    ];

    /**
     * Resizes and crops an image to the top of the image.
     *
     * @param $width
     * @param $height
     *
     * @return Image
     */
    public function TopCroppedImage($width, $height)
    {
        return $this->owner->getFormattedImage('TopCroppedImage', $width, $height);
    }

    public function generateTopCroppedImage($gd, $width, $height)
    {

        # resize
        $gd = $gd->resizeByWidth($width);

        # crop to top
        $gd = $gd->crop(0, 0, $width, $height);

        return $gd;
    }

    public function Ratio()
    {
        if (!$this->owner->Exists()) {
            return null;
        }
        return $this->owner->getWidth() / $this->owner->getHeight();
    }
    public function RatioPercent()
    {
        if (!$this->owner->Exists()) {
            return null;
        }
        return $this->owner->getWidth() / $this->owner->getHeight() * 100;
    }
    public function InvertedRatio()
    {
        if (!$this->owner->Exists()) {
            return null;
        }
        return $this->owner->getHeight() / $this->owner->getWidth();
    }
    public function InvertedRatioPercent()
    {
        if (!$this->owner->Exists()) {
            return null;
        }
        return $this->owner->getHeight() / $this->owner->getWidth() * 100;
    }
    public function RatioLessThan($ratio)
    {
        if (!$this->owner->Exists()) {
            return null;
        }
        return $this->Ratio() < $ratio;
    }
    public function RatioGreaterThan($ratio)
    {
        if (!$this->owner->Exists()) {
            return null;
        }
        return $this->Ratio() > $ratio;
    }
    public function WiderThan($width)
    {
        if (!$this->owner->Exists()) {
            return null;
        }
        return $this->owner->getWidth() > $width;
    }
    public function WiderThanOrEqual($width)
    {
        if (!$this->owner->Exists()) {
            return null;
        }
        return $this->owner->getWidth() >= $width;
    }
    public function TallerThan($height)
    {
        if (!$this->owner->Exists()) {
            return null;
        }
        return $this->owner->getHeight() > $height;
    }
    public function TallerThanOrEqual($height)
    {
        if (!$this->owner->Exists()) {
            return null;
        }
        return $this->owner->getHeight() >= $height;
    }
    public function Rotate($degrees)
    {
        if (!$this->owner->Exists()) {
            return null;
        }
        return $this->owner->getFormattedImage('RotateClockwise');
    }
    public function SetQuality($quality)
    {
        if (!$this->owner->Exists()) {
            return null;
        }
        return $this->owner->getFormattedImage('QualityVariantImage', $quality);
    }

    public function generateQualityVariantImage(Image_Backend $backend, $quality)
    {
        if (!$this->owner->Exists()) {
            return null;
        }
        $new = clone $backend;
        $new->setQuality($quality);

        return $new;
    }
}
