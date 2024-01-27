<?php

namespace QuinnInteractive\Orgsite\Element;

use DNADesign\Elemental\Models\ElementContent;
use QuinnInteractive\Orgsite\Model\Territory;
use QuinnInteractive\Orgsite\Page\TerritorySection;
use QuinnInteractive\Orgsite\Page\TerritorySectionController;
use SilverStripe\Assets\Image;
use SilverStripe\Dev\Debug;

/**
 * Class \QuinnInteractive\Orgsite\Element\ElementImageText
 *
 * @property string $Subtitle
 * @property string $ImagePos
 * @property int $ImageID
 * @method \SilverStripe\Assets\Image Image()
 */
class ElementImageText extends ElementContent
{
    private static $table_name = 'ElementImageText';
    private static $singular_name = 'Image & Text Block';
    private static $plural_name = 'Image & Text Blocks';
	private static $title = 'Image & Text Block';
    private static $icon = 'font-icon-block-story';

    private static $db = [
        'Subtitle' => 'Varchar(255)',
        'ImagePos' => "Enum('top, left, right, float-left, float-right', 'top')",
    ];
    private static $has_one = [
        'Image' => Image::class,
    ];
    private static $owns = [
        'Image',
    ];
    private static $defaults = [
        'ImagePos' => 'top',
    ];
	public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Image & Text Block');
    }

	public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        // Subtitle
        $subtitle = $fields->dataFieldByName('Subtitle');
        $subtitle->setDescription('Optional');
        $fields->removeByName('Subtitle');
        $fields->insertBefore('HTML', $subtitle);

        // Image
        $parent = $this->Parent();
        $folderName = 'Image-Text-Images';
        if ($parent) {
            /** @var Territory  */
            $ownerObject = $parent->getOwnerPage();
            if ($ownerObject && $ownerObject->ClassName == Territory::class) {
                $folderName = $ownerObject->getTerritoryAssetFolderName('Images');
            }
        }
        $fields->dataFieldByName('Image')
            ->setFolderName($folderName)
            ->setDescription('At least: 512px wide.');

        return $fields;
    }
}
