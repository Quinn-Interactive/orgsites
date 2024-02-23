<?php
namespace QuinnInteractive\Orgsite\Extension;

use QuinnInteractive\Orgsite\Lib\ColorHelpers;
use SilverStripe\Core\Config\Config;
use SilverStripe\Dev\Debug;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldGroup;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\View\ArrayData;

/**
 * Class \QuinnInteractive\Orgsite\Extension\BaseElementExtension
 *
 * @property \DNADesign\Elemental\Models\BaseElement|\QuinnInteractive\Orgsite\Extension\BaseElementColorsExtension $owner
 * @property string $BackgroundColor
 */
class BaseElementColorsExtension extends DataExtension
{
    private static $db = [
        'BackgroundColor' => 'Varchar',
        'BackgroundPattern' => 'Varchar',
        'CustomCode' => 'Text',
    ];

    public function getBackground(): ?ArrayData
    {
        $bgColor = $this->owner->getField('BackgroundColor');
        if (!$bgColor || !$this->owner || $this->owner->config()->get('disable_background_color')) {
            return null;
        }
        $colors = Config::inst()->get(SiteConfig::class, 'background-colors');
        $contrastingText = ColorHelpers::contrasting_text($bgColor);
        $contrastingText->BgClass = $colors[$bgColor]['cssClass'];
        return $contrastingText;
    }

    public function updateCMSFields(FieldList $fields): void
    {
        $fields->removeByName(['BackgroundColor', 'BackgroundPattern', 'CustomCode']);
        if (!$this->owner->config()->get('disable_background_color')) {
            $colors = Config::inst()->get(SiteConfig::class, 'background-colors');
            $colorOptions = [];
            foreach ($colors as $key => $color) {
                $colorOptions[$key] = $color['title'];
            }
            $colorField = DropdownField::create('BackgroundColor', 'Background Color', $colorOptions)
                ->setEmptyString('Default');

            $bgPattern = ColorHelpers::pattern_field('BackgroundPattern', 'Background Pattern');
            $fields->addFieldToTab('Root.Settings', FieldGroup::create($colorField, $bgPattern)->setTitle('Background'), 'ExtraClass');
        }

        $description = <<<EOT
        Raw code that will be injected at the end of this block. 
        If using CSS, you can target this element like:
        <br><pre class="text-danger">&lt;style&gt;
            #e{$this->owner->ID} {
                /* your styles here */
            }
        &lt;/style&gt;</pre>
        EOT;
        $fields->addFieldToTab(
            'Root.Settings', 
            TextareaField::create('CustomCode', 'Custom Code')
        ->setDescription($description)
        );

        parent::updateCMSFields($fields);
    }

}
