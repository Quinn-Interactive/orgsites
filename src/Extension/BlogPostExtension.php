<?php

namespace QuinnInteractive\Orgsite\Extension;

use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;

/**
 * Class \QuinnInteractive\Orgsite\Extension\BlogPostExtension
 *
 * @property \SilverStripe\Blog\Model\BlogPost|\QuinnInteractive\Orgsite\Extension\BlogPostExtension $owner
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
