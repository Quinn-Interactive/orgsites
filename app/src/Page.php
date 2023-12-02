<?php

namespace {

    use QI\App\Model\Alert;
    use SilverStripe\CMS\Model\SiteTree;
    use SilverStripe\Forms\GridField\GridField;
    use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
    use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
    use TractorCow\Fluent\Forms\VisibleLocalesColumn;

    /**
 * Class \Page
 *
 * @method \SilverStripe\ORM\ManyManyList|\QI\App\Model\Alert[] Alerts()
 */
    class Page extends SiteTree
    {
        private static $many_many = [
            'Alerts' => Alert::class,
        ];
        private static $many_many_extraFields = [
            'Alerts' => [
                'AlertSort' => 'Int',
            ],
        ];

        public function getCMSFields()
        {
            $fields = parent::getCMSFields();

            // Alerts
            $alertsConfig = GridFieldConfig_RelationEditor::create(99);
            $alertsConfig->addComponent(GridFieldOrderableRows::create('AlertSort'));
            $alertsConfig->addComponent(new VisibleLocalesColumn());
            $alerts = GridField::create(
                'Alerts',
                'Alerts',
                $this->Alerts(),
                $alertsConfig
            );
            $fields->addFieldToTab('Root.Alerts', $alerts);

            return $fields;
        }
    }
}
