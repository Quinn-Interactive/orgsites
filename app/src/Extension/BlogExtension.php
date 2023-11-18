<?php

namespace QI\App\Extension;

use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\View\ArrayData;

/**
 * Class BlogExtension
 *
 * @property \SilverStripe\Blog\Model\Blog|\QI\App\Extension\BlogExtension $owner
 * @property string $ArticleLayout
 */
class BlogExtension extends DataExtension
{

    private static $db = [
        'ArticleLayout' => "Enum('Stacked, Grid', 'Stacked')",
    ];

    /**
     * Returns a list of unique blog post years in descending order
     */
    public function BlogYears(): ArrayList|null
    {
        $blogPostYears = null;
        $blogPosts = $this->owner->blogPosts;
        if ($blogPosts && $blogPosts->count()) {
            $blogPostYearsArr = [];
            $blogPostYears = new ArrayList();
            foreach ($blogPosts as $blogPost) {
                $year = $blogPost->dbObject('PublishDate')->Year();
                if (!in_array($year, $blogPostYearsArr)) {
                    $blogPostYearsArr[] = $year;
                }
            }
            rsort($blogPostYearsArr, SORT_NUMERIC);
            foreach ($blogPostYearsArr as $year) {
                $blogPostYears->push(new ArrayData(['Year' => $year]));
            }
        }
        return $blogPostYears;
    }

    /**
     * @return void
     */
    public function updateCMSFields(FieldList $fields)
    {
        $fields->insertBefore('Content', DropdownField::create('ArticleLayout', 'Article Layout', $this->owner->dbObject('ArticleLayout')->enumValues()));
    }

}
