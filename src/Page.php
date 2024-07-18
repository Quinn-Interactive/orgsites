<?php

namespace {

    use QuinnInteractive\Orgsite\Lib\Helpers;
    use QuinnInteractive\Orgsite\Model\Alert;
    use SilverStripe\AssetAdmin\Forms\UploadField;
    use SilverStripe\Assets\Image;
    use SilverStripe\CMS\Model\RedirectorPage;
    use SilverStripe\CMS\Model\SiteTree;
    use SilverStripe\Forms\CheckboxField;
    use SilverStripe\Forms\FieldGroup;
    use SilverStripe\Forms\GridField\GridField;
    use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
    use SilverStripe\Forms\TextareaField;
    use SilverStripe\ORM\DataList;
    use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
    use TractorCow\Fluent\Forms\VisibleLocalesColumn;
    use chillerlan\QRCode\QRCode;
    use QuinnInteractive\Orgsite\Lib\LiteralFieldWrapper;
    use SilverStripe\Forms\ToggleCompositeField;

    /**
     * Class \Page
     *
     * @property string $CardSummary
     * @property int $CardImageID
     * @method \SilverStripe\Assets\Image CardImage()
     * @method \SilverStripe\ORM\ManyManyList|\QuinnInteractive\Orgsite\Model\Alert[] Alerts()
     */
    class Page extends SiteTree
    {
        private static $db = [
            'ShowBreadcrumbs' => 'Boolean',
            'CardSummary'     => 'Text',
        ];
        private static $defaults = [
            'ShowBreadcrumbs' => true,
        ];
        private static $has_one = [
            'CardImage' => Image::class,
        ];
        private static $many_many = [
            'Alerts' => Alert::class,
        ];
        private static $many_many_extraFields = [
            'Alerts' => [
                'AlertSort' => 'Int',
            ],
        ];
        private static $owns = [
            'CardImage',
        ];
        public function AlertsByType(string $type): DataList
        {
            $type = strtolower($type);
            return $this->getActiveAlerts()->filter([
                'AlertStyle' => $type,
            ]);
        }

        /**
         * Find the best summary for indexes and cards and promos
         * return the first x characters that are complete words
         * unless the last character is a period, add an ellipsis
         *
         * @param int     $chars (optional)
         * @return string
         */
        public function DescriptionOrSummary($chars = 500)
        {
            $page = $this;
            if ($this->ClassName == RedirectorPage::class && $this->RedirectionType == 'Internal') {
                $page = $this->LinkTo();
            }
            $html = $page->CardSummary ?? $page->Summary ?? $page->MetaDescription ?? $page->Content ?? $page->HTML ?? '';
            return Helpers::html_to_limited_text($html, $chars);
        }

        public function getActiveAlerts(): DataList
        {
            return $this->Alerts()->filter([
                'Active' => true,
            ])->sort('AlertSort');
        }

        public function getCMSFields()
        {
            $fields = parent::getCMSFields();

            // QR Code
            $link = $this->AbsoluteLink();
            try {
                $src = (new QRCode)->render($link);
            
                $code = <<<EOT
                <div class="text-center">
                    <img src="$src" alt="QR Code" width="300" height="300" style="max-width: 100%; height: auto;" />
                    <p><a class="btn btn-primary" href="$src" download="{$this->URLSegment}.svg">Download</a></p>
                </div>
                EOT;
                $fields->insertAfter(
                    'Metadata', 
                    ToggleCompositeField::create(
                        'QRCodeToggle', 
                        'QR Code', 
                        LiteralFieldWrapper::create('QRCode', 'QR Code', $code)
                ));
            }
            catch(Throwable $e){
                // oopsies!
            }
            

            if ($this->ClassName !== RedirectorPage::class) {
                // CardSumary
                $cardSummary = TextareaField::create('CardSummary');
                $cardSummary->setDescription('Optional. Will be used in Card/Promo Grids. If left blank, Card/Promo Grids will use Meta Description.');
                $fields->addFieldToTab('Root.CardInfo', $cardSummary);

                // CardImage
                $cardImage = UploadField::create('CardImage', 'Card Thumbnail Image')
                    ->setRightTitle('Optional. Will show up in Card/Promo Grids. Will be cropped to 16:9 ratio. Uses focuspoint. Good size for image: 960x540')
                    ->setFolderName('Card-Images');
                $fields->addFieldToTab('Root.CardInfo', $cardImage);
            }

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

        public function getSettingsFields()
        {
            $fields = parent::getSettingsFields();
            if ($this->ParentID) {
                $fields->addFieldToTab(
                    'Root.Settings',
                    FieldGroup::create(CheckboxField::create('ShowBreadcrumbs'))
                        ->setTitle('Breadcrumbs'),
                    'Visibility'
                );
            }
            return $fields;
        }
    }
}
