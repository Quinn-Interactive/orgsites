<?php

namespace QuinnInteractive\Orgsite\Controller;

use Page;
use QuinnInteractive\Orgsite\Model\CRMContact;
use QuinnInteractive\Orgsite\Model\CRMList;
use SilverStripe\Control\Controller;
use SilverStripe\Control\Director;
use SilverStripe\Control\Email\Email;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Control\HTTPResponse_Exception;
use SilverStripe\Dev\Debug;
use SilverStripe\Forms\CheckboxSetField;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\ReadonlyField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\ManyManyList;
use SilverStripe\SiteConfig\SiteConfig;

/**
 * Class \QuinnInteractive\Orgsite\Admin\FAQAdmin
 *
 */
class CRMController extends Controller
{
    private static $allowed_actions = [
        'verify',
        'verifyConfirm',
        'SignupForm',
        'VerifySettingsForm',
    ];
    private static $url_segment = 'crm';

    public function sendVerificationEmail(CRMContact $contact, DataList $lists): void
    {
        $link = $this->join_links(
            $this->config()->get('url_segment'),
            'verify',
            $contact->AccessToken,
            urlencode(json_encode($lists->column())),
        );
        $link = Director::absoluteURL($link);
        $email = Email::create();
        $email->setTo($contact->Email);
        $subject = 'Verify your account and mailing list settings';
        $siteName = SiteConfig::current_site_config()->Title;
        if ($siteName) {
            $subject = "$siteName: $subject";
        }
        $email->setSubject('Verify your account and mailing list settings');
        $email
            ->setHTMLTemplate('QuinnInteractive\\Orgsite\\Email\CRMVerificationEmail')
            ->setData([
                'Contact' => $contact,
                'Link'    => $link,
            ]);
        $email->send();
    }

    public function signup($data, Form $form)
    {
        $session = $this->getRequest()->getSession();
        $listIDs = $data['Lists'] ?? null;
        $email = $data['Email'] ?? null;
        $title = $data['Title'] ?? null;
        if (!is_array($listIDs)) {
            $listIDs = [$listIDs];
        }
        $lists = CRMList::get()->filter('ID', $listIDs);
        $email = trim($email);
        if (!$email || !Email::is_valid_address($email)) {
            return new HTTPResponse_Exception('Invalid email', 400);
        }
        /** @var CRMContact $contact */
        $contact = CRMContact::get()->filter('Email:nocase', $email)->first();
        if (!$contact) {
            $contact = CRMContact::create([
                'Title' => $title,
                'Email' => $email, 
            ]);
            $contact->write();
        }
        // Debug::dump($data); die;

        $this->sendVerificationEmail($contact, $lists);
        $session->set('ListSignupSuccess', true);
        if (isset($data['BackURL'])) {
            return $this->redirect($data['BackURL']);
        }
        return $this->redirectBack();
    }

    public function SignupForm(): Form
    {
        $fields = FieldList::create();
        $fields->push(TextField::create('Title', 'Name'));
        $fields->push(EmailField::create('Email'));
        $fields->push(CheckboxSetField::create('Lists', 'Lists', CRMList::get()));
        $actions = FieldList::create(
            FormAction::create('signup', 'Signup')->setUseButtonTag(true)
        );
        $form = Form::create($this, 'SignupForm', $fields, $actions);
        $required = ['Title', 'Email', 'Lists'];
        $form->setValidator(new RequiredFields($required));
        return $form;
    }

    public function verify(HTTPRequest $r)
    {
        $token = $r->param('ID');
        $contact = CRMContact::get()->filter('AccessToken', $token)->first();
        if (!$contact) {
            return new HTTPResponse_Exception('Contact not found', 400);
        }
        $listIDs = json_decode(urldecode($r->param('OtherID')));
        if (!is_array($listIDs) || !count($listIDs)) {
            $listIDs = 0;
        }
        $lists = CRMList::get()->filter('ID', $listIDs);
        $form = $this->VerifySettingsForm();
        $form->loadDataFrom($contact);
        $form->loadDataFrom(['Lists' => $lists]);
        return $this->customise([
            'Title' => 'Verify your account and mailing list settings',
            'Lists' => $lists,
            'Contact' => $contact,
            'VerifySettingsForm' => $form,
        ])->renderWith(['CRMVerification', Page::class]);
        // Debug::dump([$token, $lists->column('Title')]);
    }

    public function verifyConfirm($data, Form $form)
    {
        $token = $data['AccessToken'] ?? null;
        $listIDs = $data['Lists'] ?? [];
        if (!is_array($listIDs) || !count($listIDs)) {
            $listIDs = 0;
        }

        if (!$token) {
            return new HTTPResponse_Exception('Contact not found', 400);
        }
        $contact = CRMContact::get()->filter('AccessToken', $token)->first();
        if (!$contact) {
            return new HTTPResponse_Exception('Contact not found', 400);
        }
        $contact->Title = $data['Title'] ?? '';
        /** @var ManyManyList $lists */
        $lists = $contact->Lists();
        $removeIDs = $lists->exclude('ID', $listIDs)->column();
        if (count($removeIDs)) {
            foreach ($removeIDs as $id) {
                $lists->remove($id);
            }
        }
        if (is_array($listIDs) && count($listIDs)) {
            foreach ($listIDs as $id) {
                $lists->add($id);
            }
        }
        // refresh the access token
        $contact->AccessToken = CRMContact::create_short_uuid();
        $contact->Verified = true;
        $contact->write();
        return $this->customise([
            'Title' => 'Your settings have been updated',
            'Success' => true,
        ])->renderWith(['CRMVerification', Page::class]);
    }

    public function VerifySettingsForm(): Form
    {
        $fields = $this->SignupForm()->Fields();
        $fields->push(HiddenField::create('AccessToken', 'AccessToken'));
        $fields->replaceField('Email', ReadonlyField::create('Email'));
        $actions = FieldList::create(
            FormAction::create('verifyConfirm', 'Verify')->setUseButtonTag(true)
        );
        $form = Form::create($this, 'VerifySettingsForm', $fields, $actions);
        return $form;
    }
}
