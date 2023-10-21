<?php

namespace {

use SilverStripe\AssetAdmin\Forms\UploadField;
    use SilverStripe\Assets\File;
    use SilverStripe\CMS\Model\SiteTree;
    use SilverStripe\Forms\CheckboxField;

    /**
 * Class \Page
 *
 * @property bool $HighlightMenuItem
 * @property int $PageIconID
 * @method \SilverStripe\Assets\File PageIcon()
 */
class Page extends SiteTree
{
    private static $db = [
        'HighlightMenuItem' => 'Boolean',
    ];
    private static $has_one = [
        'PageIcon' => File::class,
    ];
    private static $owns = [
        'PageIcon',
    ];

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $pageIcon = UploadField::create('PageIcon');
        $pageIcon
            ->setDescription('Optional. Will be used in places like Content Grid Blocks')
            ->setFolderName('Icons')
            ->setAllowedExtensions(['svg', 'png', 'jpg', 'jpeg', 'gif']);
        $fields->insertAfter('MenuTitle', $pageIcon);

        return $fields;
    }

    /**
     * Settings Tab Fields
     * @return FieldList
     */
    public function getSettingsFields()
    {
        $fields = parent::getSettingsFields();
        if (!$this->ParentID) {
            $highlight = CheckboxField::create('HighlightMenuItem', 'Highlight Menu Item');
            $highlight->displayIf('ShowInMenus')->isChecked();
            $fields->insertAfter('ShowInMenus', $highlight);
        }
        return $fields;
    }
}

}
