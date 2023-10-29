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
