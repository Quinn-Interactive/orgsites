<?php

namespace QI\App\Lib;

use SilverStripe\Dev\Debug;
use SilverStripe\Forms\SelectField;

class Helpers
{
    public static function localize_select(SelectField $field, object $obj) 
    {
        $name = $field->getName();
        $namespace = get_class($obj);

        // localize Title
        if ($title = $field->Title()) {
            $field->setTitle(_t("{$namespace}.{$name}_Title", $title));
        } 
        // localize LeftTitle
        if ($leftTitle = $field->LeftTitle()) {
            $field->setTitle(_t("{$namespace}.{$name}_LeftTitle", $leftTitle));
        } 
        // localize RightTitle
        if ($rightTitle = $field->RightTitle()) {
            $field->setTitle(_t("{$namespace}.{$name}_RightTitle", $rightTitle));
        } 
        // localize Description
        if ($description = $field->getDescription()) {
            $field->setTitle(_t("{$namespace}.{$name}_Description", $description));
        } 
        // localize option labels
        $source = $field->getSource();
        $newSource = [];
        foreach ($source as $key => $value) {
            $newSource[$key] = _t("{$namespace}.{$name}_Options_{$key}", $value);
        }
        $field->setSource($newSource);
    }

    /**
     * WCAG Contrast Ratings.
     */
    public static function wcag_contrast_rating(float $ratio): string
    {
        $ratings = [
            'aaa' => 7,
            'aa' => 4.5,
            'aa-large' => 3,
            'fail' => 0
        ];
        foreach ($ratings as $rating => $threshold) {
            if ($ratio >= $threshold) {
                return $rating;
            }
        }
        return 'error';
    }

}
