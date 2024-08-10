<?php

namespace QuinnInteractive\Orgsite\Lib;

use SilverStripe\Forms\LiteralField;

class LiteralFieldWrapper
{
    public static function create($name, $title = false, $message = false, $stacked = false)
    {
        return LiteralField::create($name, self::wrap("<p>{$message}</p>", $title, $stacked));
    }
    public static function wrap($html, $label = false, $stacked = false)
    {
        $label = $label ? "<label class=\"form__field-label\">{$label}</label>" : '';
        $extraClass = $stacked ? 'stacked' : '';
        $result = "<div class='form-group field $extraClass'>{$label}<div class='form__field-holder'>{$html}</div></div>";
        return $result;
    }
}
