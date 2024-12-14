<?php

namespace QuinnInteractive\Orgsite\Extension;

use SilverStripe\Control\Director;
use SilverStripe\Core\Extension;
use chillerlan\QRCode\QRCode;
use QuinnInteractive\Orgsite\Lib\LiteralFieldWrapper;
use SilverStripe\Forms\ToggleCompositeField;
use SilverStripe\View\Parsers\URLSegmentFilter;
use Throwable;

class QRCodeLinkExtension extends Extension
{
    public function generateQRCode($link = null): ?string
    {

        // QR Code
        $link = $link ?? $this->owner->AbsoluteLink() ?? Director::absoluteURL($this->owner->Link());
        if (!$link) {
            return null;
        }
        try {
            $src = (new QRCode)->render($link);
            return $src;
        } catch(Throwable $e) {
            // oopsies!
        }
        return null;
    }

    public function updateCMSFields(&$fields) {
        $src = $this->owner->generateQRCode();
        if ($src) {
            $filter = URLSegmentFilter::create();
            $name = $this->owner->URLSegment ?? $filter->filter($this->owner->Title);
            $code = <<<EOT
            <div class="text-center">
                <img src="$src" alt="QR Code" width="300" height="300" style="max-width: 100%; height: auto;" />
                <p><a class="btn btn-primary" href="$src" download="{$name}.svg">Download</a></p>
            </div>
            EOT;
            $fields->insertAfter(
                'Metadata', 
                ToggleCompositeField::create(
                    'QRCodeToggle', 
                    'QR Code', 
                    LiteralFieldWrapper::create('QRCode', 'QR Code', $code)
            ));
        }
    }    
}
