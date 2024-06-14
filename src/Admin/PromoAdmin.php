<?php

namespace QuinnInteractive\Orgsite\Admin;

use QuinnInteractive\Orgsite\Action\GridFieldPublishAllButton;
use QuinnInteractive\Orgsite\Model\Promo;
use SilverStripe\Admin\ModelAdmin;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use TractorCow\Fluent\Forms\CopyLocaleAction;
use TractorCow\Fluent\Forms\DeleteAllLocalesAction;
use TractorCow\Fluent\Forms\GroupActionMenu;
use TractorCow\Fluent\Forms\VisibleLocalesColumn;

/**
 * Class \QuinnInteractive\Orgsite\Admin\FAQAdmin
 *
 */
class PromoAdmin extends ModelAdmin
{
    private static $managed_models = [
        Promo::class,
    ];
    private static $menu_icon_class = 'font-icon-circle-star';

    private static $menu_title = 'Promos';

    private static $url_segment = 'promos';

    public function getEditForm($id = null, $fields = null)
    {
        $form = parent::getEditForm($id, $fields);

        $gridFieldName = $this->sanitiseClassName($this->modelClass); //'Promo';
        $gridField = $form->Fields()->fieldByName($gridFieldName);

        if ($gridField) {
            $config = $gridField->getConfig();
            $config->addComponent(new VisibleLocalesColumn());
            $config->addComponent(new DeleteAllLocalesAction());
        }
        return $form;
    }
}
