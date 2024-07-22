<?php

namespace QuinnInteractive\Orgsite\Element;

use DNADesign\Elemental\Models\ElementContent;
use Page;
use QuinnInteractive\Orgsite\Controller\CRMController;
use QuinnInteractive\Orgsite\Extension\VideoExtension;
use QuinnInteractive\Orgsite\Model\CRMList;
use SilverStripe\Forms\CheckboxSetField;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\TextField;

class ElementListSignup extends ElementContent
{

    private static $icon = 'font-icon-block-email';
    private static $inline_editable = true;
    private static $table_name = 'ElementListSignup';
    private static $many_many = [
        'Lists' => CRMList::class,
    ];

    private static $translate = [
        'HTML',
    ];

    public function getCMSFields()
    {
		$this->beforeUpdateCMSFields(function($fields) {
            $html = $fields->dataFieldByName('HTML');
            $html->setTitle('Caption');
            $html->setDescription(_t(Page::class . '.OPTIONAL', 'Optional'));
            $fields->removeByName('HTML');
            $fields->addFieldToTab('Root.Main', $html);
        });

        $fields = parent::getCMSFields();
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
        $lists->setSource($this->Lists());
        return $form;
    }
}
