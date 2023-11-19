<?php

namespace QI\App\Page;

use Page;
use QI\App\Model\Bio;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use TractorCow\Fluent\Forms\VisibleLocalesColumn;

/**
 * Class \QI\App\Page\BioIndex
 *
 * @method \SilverStripe\ORM\DataList|\QI\App\Model\Bio[] Bios()
 */
class BioIndex extends Page
{
    private static $db = [
    ];
    private static $defaults = [
    ];
    private static $has_many = [
        'Bios' => Bio::class,
    ];
    private static $icon_class = 'font-icon-p-profile';
    private static $table_name = 'BioIndex';

    public function getCMSFields()
    {
        // wrapped so that we get our tab before the Localization tab
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            // Bios
            $config = GridFieldConfig_RelationEditor::create();
            $config->removeComponentsByType(GridFieldAddExistingAutocompleter::class);
            $config->addComponent(new VisibleLocalesColumn());
            $config->addComponent(new GridFieldOrderableRows('Sort'));
            $bios = GridField::create('Bios', 'Bios', $this->Bios(), $config);
            $fields->addFieldToTab('Root.Bios', $bios);
        });
        return parent::getCMSFields();
    }
}
