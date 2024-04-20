<?php

namespace QuinnInteractive\Orgsite\Element;

use DNADesign\Elemental\Models\ElementContent;
use Page;
use QuinnInteractive\Orgsite\Extension\VideoExtension;
use SilverStripe\Forms\TextField;

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
class ElementGoogleCalendar extends ElementContent
{
    private static $db = [
        'URL' => 'Varchar(255)',
    ];

    private static $extensions = [
        VideoExtension::class,
    ];
    private static $icon = 'font-icon-p-event-alt';
    private static $inline_editable = true;
    private static $table_name = 'ElementGoogleCalendar';
    private static $translate = [
        'HTML',
    ];

    public function getCMSFields()
    {

        $this->beforeUpdateCMSFields(function ($fields) {

        });

        $fields = parent::getCMSFields();

        // HTML
        /** @var HTMLEditorField $html */
        $html = $fields->dataFieldByName('HTML');
        $html->setDescription(_t(Page::class . '.OPTIONAL', 'Optional'));

        // URL
        /** @var TextField $url */
        $url = $fields->dataFieldByName('URL');
        $url->setDescription('Public URL to this calendar');


        return $fields;
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Google Calendar');
    }
}
