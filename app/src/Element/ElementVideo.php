<?php

namespace QI\App\Element;

use DNADesign\Elemental\Models\ElementContent;
use QI\App\Extension\VideoExtension;

/**
 * Class \QI\App\Element\ElementVideo
 *
 * @property string $VideoTitle
 * @property string $VideoURL
 * @property bool $VideoAutoPlay
 * @property int $VideoPreviewImageID
 * @method \SilverStripe\Assets\Image VideoPreviewImage()
 * @mixin \QI\App\Extension\VideoExtension
 */
class ElementVideo extends ElementContent
{

    private static $extensions = [
        VideoExtension::class,
    ];
    private static $icon = 'font-icon-block-media';
    private static $inline_editable = true;
    private static $table_name = 'ElementVideo';
    private static $translate = [
        'HTML',
        'VideoTitle',
        'VideoURL',
        'VideoPreviewImageID'
    ];

    public function getCMSFields()
    {
		$this->beforeUpdateCMSFields(function($fields) {
            $html = $fields->dataFieldByName('HTML');
            $html->setTitle('Caption');
            $html->setDescription('Optional');
            $fields->removeByName('HTML');
            $fields->insertAfter('VideoServicePreview', $html);
        });
        $fields = parent::getCMSFields();

        // label missed localized fields
        $this->updateFluentCMSField($fields->dataFieldByName('VideoTitle'));
        $this->updateFluentCMSField($fields->dataFieldByName('VideoURL'));

        return $fields;
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Video');
    }
}
