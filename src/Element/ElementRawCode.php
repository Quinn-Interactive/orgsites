<?php

namespace QuinnInteractive\Orgsite\Element;

use DNADesign\Elemental\Models\ElementContent;
use Page;
use QuinnInteractive\Orgsite\Extension\VideoExtension;

/**
 * Class \QuinnInteractive\Orgsite\Element\ElementVideo
 *
 * @property string $VideoTitle
 * @property string $VideoURL
 * @property bool $VideoAutoPlay
 * @property int $VideoPreviewImageID
 * @method \SilverStripe\Assets\Image VideoPreviewImage()
 * @mixin \QuinnInteractive\Orgsite\Extension\VideoExtension
 */
class ElementRawCode extends ElementContent
{
    private static $db = [
        'RawCode' => 'Text',
    ];

    private static $extensions = [
        VideoExtension::class,
    ];
    private static $icon = 'font-icon-block-embed';
    private static $inline_editable = true;
    private static $table_name = 'ElementRawCode';
    private static $translate = [
        'HTML',
        'RawCode',
    ];

    public function getCMSFields()
    {

        $this->beforeUpdateCMSFields(function ($fields) {

        });

        $fields = parent::getCMSFields();

        // HTML
        /** @var HTMLEditorField */
        $html = $fields->dataFieldByName('HTML');
        $html->setDescription(_t(Page::class . '.OPTIONAL', 'Optional'));


        return $fields;
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Raw Code');
    }
}
