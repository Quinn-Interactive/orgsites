<?php

namespace QI\App\Page;

use PageController;
use SilverStripe\Dev\Debug;
use SilverStripe\ORM\PaginatedList;

/**
 * Class \QI\App\Page\ArticleIndexController
 *
 * @property \QI\App\Page\ArticleIndex $dataRecord
 * @method \QI\App\Page\ArticleIndex data()
 * @mixin \QI\App\Page\ArticleIndex
 */
class ArticleIndexController extends PageController
{
    public function PaginatedList()
    {
        $r = $this->getRequest();
        $children = ArticlePage::get()->filter('ParentID', $this->ID)->Sort('Date');
        $list = PaginatedList::create($children, $r);
        return $list;
    }
}
