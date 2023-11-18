<?php

namespace {

    use SilverStripe\CMS\Controllers\ContentController;
    use SilverStripe\CMS\Model\SiteTree;
    use SilverStripe\CMS\Search\ContentControllerSearchExtension;
    use SilverStripe\CMS\Search\SearchForm;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\FormAction;
    use SilverStripe\Forms\TextField;

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
            parent::init();
        }

        // public function SearchForm(): SearchForm
        // {
        //     $searchText = '';

        //     if ($this->getRequest() && $this->getRequest()->getVar('Search')) {
        //         $searchText = $this->getRequest()->getVar('Search');
        //     }

        //     $fields = new FieldList(
        //         TextField::create('Search', false, $searchText)
        //             ->setAttribute('placeholder', _t('SilverStripe\\CMS\\Search\\SearchForm.SEARCH', 'Search'))
        //     );
        //     $actions = new FieldList(
        //         FormAction::create('results', _t('SilverStripe\\CMS\\Search\\SearchForm.GO', 'Go'))
        //             ->setAttribute('title', 'Go')
        //             ->setUseButtonTag(true)
        //     );
        //     /** @skipUpgrade */
        //     $form = SearchForm::create($this, 'SearchForm', $fields, $actions);
        //     $form->addExtraClass('SearchForm');
        //     $form->setFormAction('/home/SearchForm');
        //     $form->classesToSearch([SiteTree::class]);
        //     return $form;
        // }
    }
}
