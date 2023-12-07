<?php

namespace QI\App\Element;

use DNADesign\Elemental\Models\BaseElement;
use gorriecoe\Link\Models\Link;
use QI\App\Model\Promo;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\TreeDropdownField;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\SS_List;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

/**
 * Class \QI\App\Element\ElementPromos
 *
 * @property string $PromoType
 * @property string $PromoLayout
 * @property int $MaxItems
 * @property bool $HideImages
 * @property int $IndexID
 * @method \SilverStripe\CMS\Model\SiteTree Index()
 * @method \SilverStripe\ORM\DataList|\QI\App\Model\Promo[] Promos()
 */
class ElementPromos extends BaseElement
{

    private static $db = [
        'PromoType'   => "Enum('badges, stack, cards, blocks', 'cards')",
        'PromoLayout' => "Enum('grid, slider','grid')",
        'MaxItems'    => "Int",
        'HideImages'    => "Boolean",
    ];
    private static $description = 'Promos';
    private static $has_many = [
        'Promos' => Promo::class,
    ];
    private static $has_one = [
        'Index' => SiteTree::class,
    ];
    private static $icon = 'font-icon-block-promo';
    private static $inline_editable = false;
    private static $owns = [
        'Promos',
    ];
    private static $plural_name = 'Promos';
    private static $singular_name = 'Promos';
    private static $table_name = 'ElementPromos';

    public function CombinedPromos(): SS_List
    {
        /** @var SiteTree */
        $index = $this->Index();
        $list = null;
        if ($index->exists() && $index->AllChildren()) {
            /** @var DataList */
            $list = $index->AllChildren();
        } else {
            /** @var ArrayList */
            $list = $this->Promos();
        }
        if ($this->MaxItems) {
            $list = $list->limit($this->MaxItems);
        }
        return $list;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        // PromoType
        $fields->dataFieldByName('PromoType')->setDescription('You should have at least 3 promos for cards, and 4 for badges');

        // PromoLayout
        $layout = $fields->dataFieldByName('PromoLayout')->setDescription('slider will make one line of promos where you can go forward or back. Blocks and stacks are always stacked and cannot be sliders. Make sure your items all have images the same aspect ratio, and text similar lengths.');

        // MaxItems
        $fields->dataFieldByName('MaxItems')->setDescription('Maximum number of items to show. If 0 or empty, block will show all items.');

        $layout->displayIf('PromoType')->isNotEqualTo('stack')
            ->andIf('PromoType')->isNotEqualTo('blocks');

        // Index
        $index = TreeDropdownField::create('IndexID', 'Index Source', SiteTree::class);
        $index->setDescription('Optional. If page selected, it’s subpages will be used as the promos, and use their Card Images and Card Summarys');
        $fields->replaceField('IndexID', $index);

        $promos = $fields->dataFieldByName('Promos');
        if ($promos) {
            /** @var GridFieldConfig */
            $config = $promos->getConfig();
            $config->removeComponentsByType(GridFieldAddExistingAutocompleter::class);
            $config->addComponent(new GridFieldOrderableRows('Sort'));
            $fields->removeByName('Promos');
            $fields->insertAfter('IndexID', $promos);
        }

        return $fields;
    }

    public function GridClasses(): string
    {
        // badges, stack, cards, blocks
        switch ($this->PromoType) {
            case 'badges':
                return 'row row-cols-2 row-cols-sm-3 row-cols-lg-4 row-cols-xl-6 g-4';
                break;
            case 'cards':
                return 'row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-4';
                break;
            case 'cards':
                return 'row row-cols-1 row-cols-lg-2 g-4';
                break;
            case 'stack':
            default:
                return 'vstack';
                break;
        }
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Promos');
    }

    public function onBeforeWrite()
    {
        parent::onBeforeWrite();
        if (in_array($this->PromoType, ['stack', 'blocks'])) {
            $this->PromoLayout = 'grid';
        }
    }
}
