<?php

namespace QI\App\Page;

use Page;
use SilverStripe\Lumberjack\Model\Lumberjack;

/**
 * Class \QI\App\Page\ArticleIndex
 *
 * @mixin \SilverStripe\Lumberjack\Model\Lumberjack
 */
class ArticleIndex extends Page
{
    private static $allowed_children = [
        ArticlePage::class,
    ];

    private static $extensions = [
        Lumberjack::class,
    ];
    private static $icon_class = 'font-icon-news';
    private static $table_name = 'ArticleIndex';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        return $fields;
    }
}
