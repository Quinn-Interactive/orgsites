<?php

namespace QI\App\Page;

use DNADesign\Elemental\Extensions\ElementalPageExtension;
use Page;

/**
 * Class \QI\App\Page\BlockPage
 *
 * @property int $ElementalAreaID
 * @method \DNADesign\Elemental\Models\ElementalArea ElementalArea()
 * @mixin \DNADesign\Elemental\Extensions\ElementalPageExtension
 */
class BlockPage extends Page
{
    private static $extensions = [
        ElementalPageExtension::class,
    ];
    private static $icon_class = 'font-icon-p-alt-2';
    private static $table_name = 'BlockPage';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->dataFieldByName('Title')->setDescription(_t(self::class . '.TITLE_DESCRIPTION', 'Because this is a Block Page, the title will not display on the page. Make sure to set and display the title in your first block.'));

        return $fields;
    }
}
