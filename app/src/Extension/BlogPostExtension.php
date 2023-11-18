<?php

namespace QI\App\Extension;

use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;

/**
 * Class \QI\App\Extension\BlogPostExtension
 *
 * @property \SilverStripe\Blog\Model\BlogPost|\QI\App\Extension\BlogPostExtension $owner
 */
class BlogPostExtension extends DataExtension
{

    /**
     * @return void
     */
    public function updateCMSFields(FieldList $fields)
    {
        $fields->dataFieldByName('FeaturedImage')->setFolderName('Blog-Images');
    }
}
