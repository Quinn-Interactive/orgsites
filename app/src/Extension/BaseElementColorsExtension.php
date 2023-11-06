<?php
namespace QI\App\Extension;

use QI\App\Lib\ColorHelpers;
use SilverStripe\Core\Config\Config;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\View\ArrayData;

/**
 * Class \QI\App\Extension\BaseElementExtension
 *
 * @property \DNADesign\Elemental\Models\BaseElement|\QI\App\Extension\BaseElementColorsExtension $owner
 * @property string $BackgroundColor
 */
class BaseElementColorsExtension extends DataExtension
{
    private static $db = [
        'BackgroundColor' => 'Varchar',
    ];

    public function getBackgroundColor(): ?ArrayData
    {
        $bgColor = $this->owner->getField('BackgroundColor');
        if (!$this->owner || !$bgColor || $this->owner->config()->get('disable_background_color')) {
            return null;
        }
        $colors = Config::inst()->get(SiteConfig::class, 'background-colors');
        $contrastingText = ColorHelpers::contrasting_text($bgColor);
        $contrastingText->BgClass = $colors[$bgColor]['cssClass'];
        return $contrastingText;
    }

    public function updateCMSFields(FieldList $fields): void
    {
        $fields->removeByName('BackgroundColor');
        if (!$this->owner->config()->get('disable_background_color')) {
            $colors = Config::inst()->get(SiteConfig::class, 'background-colors');
            $colorOptions = [];
            foreach ($colors as $key => $color) {
                $colorOptions[$key] = $color['title'];
            }
            $colorField = DropdownField::create('BackgroundColor', 'Background Color', $colorOptions)
                ->setEmptyString('Default');
            $fields->addFieldToTab('Root.Main', $colorField);
        }

        parent::updateCMSFields($fields);
    }

}
