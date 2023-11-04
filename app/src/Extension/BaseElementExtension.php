<?php
namespace QI\App\Extension;

use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\ORM\DataExtension;
use Jawira\CaseConverter\Convert;

/**
 * Class \QI\App\Extension\BaseElementExtension
 *
 * @property \DNADesign\Elemental\Models\BaseElement|\QI\App\Extension\BaseElementExtension $owner
 */
class BaseElementExtension extends DataExtension {

    /*
     * return the short name (ie, not fully qualified) of the class
     */
    public function getCSSClassName() {
        $array = array_map(function ($s) {
            $convert = new Convert($s);
            return $convert->fromPascal()->toKebab();
        }, explode(' ',$this->owner->CSSClasses(BaseElement::class)));
        return join(' ', $array);
    }

    public function getPreviousElement() {
        $parent = $this->owner->Parent();
        if ($parent && $parent->exists()) {
            return $parent->Elements()->filter('Sort:LessThan', $this->owner->Sort)->Sort('Sort', 'DESC')->first();
        }
    }

    public function getNextElement() {
        $parent = $this->owner->Parent();
        if ($parent && $parent->exists()) {
            return $parent->Elements()->filter('Sort:GreaterThan', $this->owner->Sort)->first();
        }
    }

    // override this is your element to change the default summary value
    public function getSummary() {
        return null;
    }

    // allow elements to change their summary in the elemental grid field
    public function updateBlockSchema(&$blockSchema) {
        if ($this->owner->getSummary()) {
            $blockSchema['content'] = $this->owner->getSummary();
        }
    }

}
