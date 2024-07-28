<?php

namespace QuinnInteractive\Orgsite\Element;

use DNADesign\Elemental\Models\ElementContent;
use Page;
use QuinnInteractive\Orgsite\Controller\CRMController;
use QuinnInteractive\Orgsite\Extension\VideoExtension;
use QuinnInteractive\Orgsite\Model\CRMList;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\CheckboxSetField;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\TextField;

class ElementListSignup extends ElementContent
{

    private static $icon = 'font-icon-block-email';
    private static $inline_editable = true;
    private static $table_name = 'ElementListSignup';
    private static $many_many = [
        'Lists' => CRMList::class,
    ];
    private static $db = [
        'SuccessMessage' => 'HTMLText',
    ];

    private static $translate = [
        'HTML',
        'SuccessMessage',
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->dataFieldByName('SuccessMessage')
            ->setRows(7)
            ->setDescription('Optional. Below this there will be message informing the visitor that they will receive a confirmation email with a link that they will need to click on before they will be signed up.');
        $lists = $fields->dataFieldByName('Lists');
        if ($lists) {
            $fields->removeByName('Lists');
            $fields->addFieldToTab('Root.Main', CheckboxSetField::create('Lists', 'Allow signup for these lists', CRMList::get()));
        }

        return $fields;
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'List Signup');
    }

    public function SignupForm(): Form {
        $form = singleton(CRMController::class)->SignupForm();
        $fields = $form->Fields();
        /** @var CheckboxSetField */
        $lists = $fields->dataFieldByName('Lists');
        $backUrl = Controller::join_links($this->getPage()->Link(), '#' . $this->getAnchor());
        $fields->push(HiddenField::create('BackURL', 'BackURL', $backUrl));
        $lists->setSource($this->Lists());
        return $form;
    }

    public function getListSignupSuccess(): bool 
    {
        $controller = Controller::curr();
        $session = $controller->getRequest()->getSession();
        $success = $session->get('ListSignupSuccess') ?? false;
        $session->clear('ListSignupSuccess');
        return $success;
    }
}
