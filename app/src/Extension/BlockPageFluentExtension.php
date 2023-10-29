<?php

namespace QI\App\Extension;

use SilverStripe\Core\Extension;
use TractorCow\Fluent\Model\Locale;

/**
 * Class \QI\App\Extension\BlockPageFluentExtension
 *
 * @property \QI\App\Page\BlockPage|\QI\App\Extension\BlockPageFluentExtension $owner
 */
class BlockPageFluentExtension extends Extension
{
    /**
     * Override default Fluent fallback
     *
     * @param string $query
     * @param string $table
     * @param string $field
     * @param Locale $locale
     */
    public function updateLocaliseSelect(&$query, $table, $field, Locale $locale)
    {
        // disallow elemental data inheritance in the case that published localised page instance already exists
        if ($field == 'ElementalAreaID' && $this->owner->isPublishedInLocale()) {
            $query = '"' . $table . '_Localised_' . $locale->getLocale() . '"."' . $field . '"';
        }
    }
}
