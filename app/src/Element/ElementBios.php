<?php

namespace QI\App\Element;

use DNADesign\Elemental\Models\ElementContent;
use Page;
use QI\App\Model\Bio;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use TractorCow\Fluent\Forms\VisibleLocalesColumn;

/**
 * Class \QI\App\Element\ElementBanner
 *
 * @method \SilverStripe\ORM\ManyManyList|\QI\App\Model\Bio[] Bios()
 */
class ElementBios extends ElementContent
{
    private static $icon = 'font-icon-block-group';
    private static $inline_editable = false;
    private static $many_many = [
        'Bios' => Bio::class,
    ];
    private static $many_many_extraFields = [
        'Bios' => [
            'BioSort' => 'Int',
        ],
    ];
    private static $owns = [
        'Bios',
    ];
    private static $plural_name = 'Bios';
    private static $singular_name = 'Bios';
    private static $table_name = 'ElementBios';
    private static $title = 'Bios';

    public function getCMSFields()
    {
        // Debug::dump($this->getBlockConfig()); die;
        $fields = parent::getCMSFields();

        // HTML
        /** @var HTMLEditorField */
        $html = $fields->dataFieldByName('HTML');
        $html->setDescription(_t(Page::class . '.OPTIONAL', 'Optional'));

        // Bios
        $bios = $fields->dataFieldByName('Bios');
        if ($bios) {
            $fields->removeByName('Bios');
            /** @var GridFieldConfig */
            $config = $bios->getConfig();
            $config->addComponent(new GridFieldOrderableRows('BioSort'));
            $config->addComponent(new VisibleLocalesColumn());
            $fields->addFieldToTab('Root.Main', $bios);
        }

        return $fields;
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Bios');
    }
}
