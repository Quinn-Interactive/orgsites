<?php

namespace QuinnInteractive\Orgsite\Model;

use SilverStripe\ORM\DataObject;

class CRMList extends DataObject
{
    private static $belongs_many_many = [
        'Contacts' => CRMContact::class,
    ];
    private static $db = [
        'Name' => 'Varchar(128)',
        'Sort' => 'Int',
    ];
    private static $default_sort = 'Sort';
    private static $plural_name = 'Lists';
    private static $singular_name = 'List';
    private static $summary_fields = [
        'Name',
        'Contacts.Count' => 'Contacts',
    ];
    private static $table_name = 'CRMList';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('Sort');
        $contacts = $fields->dataFieldByName('Contacts');
        if ($contacts) {
            $fields->removeByName('Contacts');
            $fields->addFieldToTab('Root.Main', $contacts);
        }
        return $fields;
    }
}
