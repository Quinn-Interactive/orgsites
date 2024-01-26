<?php

namespace QuinnInteractive\Orgsite\Lib;

use SilverStripe\Forms\SelectField;
use SilverStripe\View\Parsers\URLSegmentFilter;

class Helpers
{

    public static function generate_slug($string)
    {
        $filter = URLSegmentFilter::create();
        return $filter->filter($string);
    }
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

    public static function html_to_limited_text($html, $chars = 0): string
    {
        // strip newlines
        $html = preg_replace('/[\n\r]+/s', ' ', $html);

        $clean = strip_tags($html);

        $text = substr($clean, 0, $chars);

        // if chars = 0, no clipping, so return it.
        if (!$chars) {
            return $clean;
        }

        // if we didn't need to clip, return it.
        if ($clean == $text) {
            return $text;
        }

        // strip and ...
        $text = preg_replace('/^(.*)\s+\S*$/s', '$1', $text);
        if (preg_match('/\.$/', $text) || $clean == $text) {
            return $text;
        } else {
            return $text . '…';
        }
    }

    /**
     * WCAG Contrast Ratings.
     */
    public static function wcag_contrast_rating(float $ratio): string
    {
        $ratings = [
            'aaa'      => 7,
            'aa'       => 4.5,
            'aa-large' => 3,
            'fail'     => 0
        ];
        foreach ($ratings as $rating => $threshold) {
            if ($ratio >= $threshold) {
                return $rating;
            }
        }
        return 'error';
    }
}
