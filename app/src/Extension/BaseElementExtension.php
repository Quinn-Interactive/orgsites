<?php
namespace QI\App\Extension;

use DNADesign\Elemental\Models\BaseElement;
use Jawira\CaseConverter\Convert;
use SilverStripe\ORM\DataExtension;

/**
 * Class \QI\App\Extension\BaseElementExtension
 *
 * @property \DNADesign\Elemental\Models\BaseElement|\QI\App\Extension\BaseElementExtension $owner
 */
class BaseElementExtension extends DataExtension
{
    // overriden for Fluent
    public function isPublished() {
        return $this->owner->isPublishedInLocale();
    }

    public function isLiveVersion() {
        return $this->owner->isPublishedInLocale() && !$this->owner->stagesDifferInLocale();
    }
        

    /*
     * return the short name (ie, not fully qualified) of the class
     */
    public function getCSSClassName()
    {
        $array = array_map(function ($s) {
            $convert = new Convert($s);
            return $convert->fromPascal()->toKebab();
        }, explode(' ', $this->owner->CSSClasses(BaseElement::class)));
        return join(' ', $array);
    }

    public function getNextElement()
    {
        $parent = $this->owner->Parent();
        if ($parent && $parent->exists()) {
            return $parent->Elements()->filter('Sort:GreaterThan', $this->owner->Sort)->first();
        }
    }

    public function getPreviousElement()
    {
        $parent = $this->owner->Parent();
        if ($parent && $parent->exists()) {
            return $parent->Elements()->filter('Sort:LessThan', $this->owner->Sort)->Sort('Sort', 'DESC')->first();
        }
    }

    // override this is your element to change the default summary value
    public function getSummary()
    {
        return null;
    }

    // allow elements to change their summary in the elemental grid field
    public function updateBlockSchema(&$blockSchema)
    {
        if ($this->owner->getSummary()) {
            $blockSchema['content'] = $this->owner->getSummary();
        }
    }

}
