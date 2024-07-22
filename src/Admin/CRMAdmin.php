<?php

namespace QuinnInteractive\Orgsite\Admin;

use QuinnInteractive\Orgsite\Model\CRMContact;
use QuinnInteractive\Orgsite\Model\CRMList;
use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Forms\GridField\GridField;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

/**
 * Class \QuinnInteractive\Orgsite\Admin\FAQAdmin
 *
 */
class CRMAdmin extends ModelAdmin
{
    private static $managed_models = [
        CRMContact::class,
        CRMList::class,
    ];
    private static $menu_icon_class = 'font-icon-address-card';
    private static $menu_title = 'CRM';
    private static $url_segment = 'crm';

    public function getEditForm($id = null, $fields = null)
    {
        $form = parent::getEditForm($id, $fields);

        // get gridfield
        $gridField = $form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass));
        /** @var GridField $gridField */
        $gridfieldConfig = $gridField->getConfig();

        switch ($this->modelClass) {
            // make read only for ProductOption but leave CSV import/export in
            case CRMList::class:
                // remove delete & edit buttons
                $gridfieldConfig
                    ->addComponent(GridFieldOrderableRows::create('Sort'));
                break;
                // Disable everything but editing on ElementProductCollection admin
            default:
                break;
        }

        return $form;
    }

}
