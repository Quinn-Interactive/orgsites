<?php

namespace QI\App\Lib;

use SilverStripe\Forms\LiteralField;

class LiteralFieldWrapper
{
    public static function create($name, $title = false, $message = false)
    {
        return LiteralField::create($name, self::wrap("<p>${message}</p>", $title));
    }
    public static function wrap($html, $label = false)
    {
        $label = $label ? "<label class=\"form__field-label\">${label}</label>" : '';
        $result = "<div class='form-group field'>${label}<div class='form__field-holder'>${html}</div></div>";
        return $result;
    }
}
