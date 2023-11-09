<?php

namespace QI\App\Page;

use Page;
use SilverStripe\Forms\DatetimeField;
use SilverStripe\ORM\FieldType\DBDatetime;

/**
 * Class \QI\App\Page\ArticlePage
 *
 * @property string $Date
 */
class ArticlePage extends Page
{
    private static $allowed_children = [];
    private static $allowed_parents = [
        ArticleIndex::class,
    ];
    private static $can_be_root = false;

    private static $db = [
        'Date' => 'DBDatetime',
    ];
    private static $icon_class = 'font-icon-p-news-item';
    private static $show_in_sitetree = false;
    private static $summary_fields = [
        'Date' => 'Date',
    ];
    private static $defaults = [
        'ShowInMenus' => false,
    ];
    private static $table_name = 'ArticlePage';
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->insertBefore('Content', DatetimeField::create('Date'));
        return $fields;
    }
    public function onBeforeWrite()
    {
        parent::onBeforeWrite();
        if (!$this->Date) {
            $this->Date = DBDatetime::now();
        }
    }
}
