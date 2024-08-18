<?php

namespace QuinnInteractive\Orgsite\Model;

use PascalDeVink\ShortUuid\ShortUuid;
use Ramsey\Uuid\Uuid;
use SilverStripe\Forms\CheckboxSetField;
use SilverStripe\Forms\EmailField;
use SilverStripe\ORM\DataObject;

class CRMContact extends DataObject
{
    private static $db = [
        'Title'        => 'Varchar(128)',
        'Email'       => 'Varchar(255)',
        // 'Phone'       => 'Varchar(16)',
        'Verified'    => 'Boolean',
        'AccessToken' => 'Varchar(22)',
    ];
    private static $indexes = [
        'Email' => true,
    ];
    private static $many_many = [
        'Lists' => CRMList::class,
    ];
    private static $plural_name = 'Contacts';
    private static $singular_name = 'Contact';
    private static $summary_fields = [
        'Title' => 'Name',
        'Email',
        'Phone',
        'Verified',
        'AccessToken',
    ];
    private static $table_name = 'CRMContact';
    
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->replaceField('Email', EmailField::create('Email'));
        $lists = $fields->dataFieldByName('Lists');
        if ($lists) {
            $fields->removeByName('Lists');
            $fields->addFieldToTab('Root.Main', CheckboxSetField::create('Lists', 'Lists', CRMList::get()));
        }

        $accessToken = $fields->dataFieldByName('AccessToken');
        if ($accessToken) {
            $fields->replaceField('AccessToken', $accessToken->performReadonlyTransformation());
        }
        return $fields;
    }

    public function onBeforeWrite()
    {
        parent::onBeforeWrite();
        if (!$this->AccessToken) {
            $this->AccessToken = self::create_short_uuid();
        }
    }

    public function setVerified(bool $verified = true): void
    {
        $this->Verified = $verified;
        $this->write();
    }

    public function validate()
    {
        $result = parent::validate();

        if (!$this->Email) {
            $result->addError('Email is required');
        }

        if ($this->Email && self::get()->filter('Email', $this->Email)->exclude('ID', $this->ID)->Count()) {
            $result->addError('Email must be unique');
        }

        return $result;
    }

    public static function create_short_uuid()
    {
        $longUuid = Uuid::uuid4();
        $uuid = new ShortUuid();
        return $uuid->encode($longUuid);
    }

}
