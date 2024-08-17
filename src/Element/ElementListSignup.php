<?php

namespace QuinnInteractive\Orgsite\Element;

use DNADesign\Elemental\Models\ElementContent;
use QuinnInteractive\Orgsite\Admin\CRMAdmin;
use QuinnInteractive\Orgsite\Controller\CRMController;
use QuinnInteractive\Orgsite\Model\CRMList;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\CheckboxSetField;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\LiteralField;

class ElementListSignup extends ElementContent
{
    private static $db = [
        'SuccessMessage' => 'HTMLText',
    ];

    private static $icon = 'font-icon-block-email';
    private static $inline_editable = true;
    private static $many_many = [
        'Lists' => CRMList::class,
    ];
    private static $table_name = 'ElementListSignup';

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
            if (!CRMList::get()->Count()) {
                $listsLink = CRMAdmin::create()->getLinkForModelTab(CRMList::class);
                $fields->addFieldToTab(
                    'Root.Main',
                    LiteralField::create(
                        'ListsNotice',
                        'Lists',
                        "<p>No mailing lists defined. You should define at least one mailing list: <a href='{$listsLink}'>Mailing Lists</a></p>"
                    )
                );
            } else {
                $fields->addFieldToTab(
                    'Root.Main',
                    CheckboxSetField::create('Lists', 'Allow signup for these lists', CRMList::get())
                        ->setDescription('You should choose at least one list')
                );
            }
        }

        return $fields;
    }

    public function getListSignupSuccess(): bool
    {
        $controller = Controller::curr();
        $session = $controller->getRequest()->getSession();
        $success = $session->get('ListSignupSuccess') ?? false;
        $session->clear('ListSignupSuccess');
        return $success;
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'List Signup');
    }

    public function SignupForm(): Form
    {
        /** @var Form $form */
        $form = singleton(CRMController::class)->SignupForm();
        $fields = $form->Fields();
        $backUrl = Controller::join_links($this->getPage()->Link(), '#' . $this->getAnchor());
        $fields->push(HiddenField::create('BackURL', 'BackURL', $backUrl));

        /** @var CheckboxSetField */
        $lists = $fields->dataFieldByName('Lists');
        if ($this->Lists()->Count() == 1) {
            $fields->replaceField('Lists', HiddenField::create('Lists', 'Lists', $this->Lists()->first()->ID));
        } else {
            $lists->setSource($this->Lists()->map());
            $lists->setValue($this->Lists()->column());
        }
        if ($this->Lists()->Count() <= 1) {

        }
        return $form;
    }
}
