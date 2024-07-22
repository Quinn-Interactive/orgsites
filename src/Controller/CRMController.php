<?php

namespace QuinnInteractive\Orgsite\Controller;

use QuinnInteractive\Orgsite\Model\CRMList;
use SilverStripe\Control\Controller;
use SilverStripe\Dev\Debug;
use SilverStripe\Forms\CheckboxSetField;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TextField;

/**
 * Class \QuinnInteractive\Orgsite\Admin\FAQAdmin
 *
 */
class CRMController extends Controller
{
    private static $allowed_actions = [
        'SignupForm',
    ];
    private static $url_segment = 'crm';

    public function SignupForm(): Form {
        $fields = FieldList::create();
        $fields->push(TextField::create('Name'));
        $fields->push(EmailField::create('Email'));
        $fields->push(CheckboxSetField::create('Lists', 'Lists', CRMList::get()));
        $actions = FieldList::create(
            FormAction::create('signup', 'Signup')->setUseButtonTag(true)
        );
        $form = Form::create($this, 'SignupForm', $fields, $actions);
        $required = ['Name', 'Email', 'Lists'];
        $form->setValidator(new RequiredFields($required));
        return $form;
    }

    public function signup($data, Form $form) {
        return Debug::dump($data);
    }
}
