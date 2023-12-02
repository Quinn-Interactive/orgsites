<?php

namespace QI\App\Admin;

use QI\App\Action\GridFieldPublishAllButton;
use QI\App\Model\Alert;
use SilverStripe\Admin\ModelAdmin;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use TractorCow\Fluent\Forms\VisibleLocalesColumn;

/**
 * Class \QI\App\Admin\FAQAdmin
 *
 */
class AlertAdmin extends ModelAdmin
{
    private static $managed_models = [
        Alert::class,
    ];
    private static $menu_icon_class = 'font-icon-attention';

    private static $menu_title = 'Alerts';

    private static $url_segment = 'alerts';

    public function getEditForm($id = null, $fields = null)
    {
        $form = parent::getEditForm($id, $fields);

        $gridFieldName = $this->sanitiseClassName($this->modelClass); //'Alert';
        $gridField = $form->Fields()->fieldByName($gridFieldName);

        if ($gridField) {
            $config = $gridField->getConfig();
            $config->addComponent(new VisibleLocalesColumn());

        }
        return $form;
    }

    public function getList()
    {
        return Alert::get()->filter('ClassName', Alert::class);
    }

}
