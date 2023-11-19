<?php

namespace QI\App\Page;

use DNADesign\Elemental\Extensions\ElementalPageExtension;
use Page;
use QI\App\Extension\BlockPageFluentExtension;
use QI\App\Lib\LiteralFieldWrapper;
use TractorCow\Fluent\Model\Locale;

/**
 * Class \QI\App\Page\BlockPage
 *
 * @property int $ElementalAreaID
 * @method \DNADesign\Elemental\Models\ElementalArea ElementalArea()
 * @mixin \DNADesign\Elemental\Extensions\ElementalPageExtension
 * @mixin \QI\App\Extension\BlockPageFluentExtension
 */
class BlockPage extends Page
{
    private static $extensions = [
        ElementalPageExtension::class,
        BlockPageFluentExtension::class,
    ];
    private static $field_include = [
        'ElementalAreaID',
    ];
    private static $icon_class = 'font-icon-p-alt-2';
    private static $table_name = 'BlockPage';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->dataFieldByName('Title')->setDescription(_t(self::class . '.TITLE_DESCRIPTION', 'Because this is a Block Page, the title will not display on the page. Make sure to set and display the title in your first block.'));
        
        // Localization Note
        if (Locale::get()->Count() > 1) {
            $localizationNote = LiteralFieldWrapper::create('BlocksFLuentNote', false, _t(self::class . '.BLOCKS_DESCRIPTION', 'Each localized version of this page will have different blocks, so editing/adding/reordering/deleting a block only changes it in that locale. When you copy this page from one locale to another, it will make copies of all the blocks from the original locale into the other locale.'));
            $fields->insertAfter('MenuTitle', $localizationNote);
        }

        return $fields;
    }

    public function onBeforeWrite()
    {
        parent::onBeforeWrite();

        if (!$this->isDraftedInLocale() && $this->isInDB() && !$this->isArchived()) {
            $elementalArea = $this->ElementalArea();

            $elementalAreaNew = $elementalArea->duplicate();
            $this->ElementalAreaID = $elementalAreaNew->ID;
        }

        return;
    }
}
