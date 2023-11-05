<?php

namespace QI\App\Page;

use DNADesign\Elemental\Extensions\ElementalPageExtension;
use Page;
use QI\App\Extension\BlockPageFluentExtension;

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

        $fields->dataFieldByName('Title')->setDescription(_t(self::class . '.TITLE_DESCRIPTION', 'Becasue this is a Block Page, the title will not display on the page. Make sure to set and display the title in your first block.'));
        // Localization Note
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
