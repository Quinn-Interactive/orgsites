<?php

namespace {

    use SilverStripe\CMS\Controllers\ContentController;
    use SilverStripe\CMS\Search\ContentControllerSearchExtension;
    use SilverStripe\Dev\Debug;
    use SilverStripe\View\SSViewer;

    /**
 * Class \PageController
 *
 * @property \Page $dataRecord
 * @method \Page data()
 * @mixin \Page
 * @mixin \SilverStripe\CMS\Search\ContentControllerSearchExtension
 */
    class PageController extends ContentController
    {
        private static $extensions = [
            ContentControllerSearchExtension::class,
        ];

        protected function init()
        {
            // Debug::dump($this->getViewerTemplates());die;
            parent::init();
        }
    }
}
