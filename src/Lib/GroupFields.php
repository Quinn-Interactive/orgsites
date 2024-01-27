<?php

namespace QuinnInteractive\Orgsite\Lib;

use SilverStripe\Forms\FieldGroup;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\FormField;

class GroupFields
{
    /**
     * Group existing fields
     *
     * @param array|FieldList $list array (of names from $fields or FormFields ) or FieldList of the fields to group
     * @param string|null $title optional title to add to the group
     * @param FieldList|null $fields the main FieldList to add the group to and delete the original fields from. If empty, just returns the group
     * @param FormField|string|null $before the FormField or name of the field in $fields to insert the group before (needs to still be in $fields).
     * @return void
     */
    public static function create($list, $title = null, &$fields = null, $before = null)
    {
        $fieldlist = FieldList::create();
        if (is_array($list)) {
            foreach ($list as $field) {
                if (is_string($field) && $fields) {
                    $field = $fields->dataFieldByName($field);
                }
                $fieldlist->push($field);
                $fields->removeByName($field->getName(), true);
            }
        } elseif (is_object($list)) {
            $fieldlist = $list;
        }
        $group = FieldGroup::create($fieldlist);
        if ($title) {
            $group->setTitle($title);
        }
        if ($fields && $before) {
            $fields->insertBefore($before, $group);
        } else {
            $fields->push($group);
        }
        return $group;
    }
}
