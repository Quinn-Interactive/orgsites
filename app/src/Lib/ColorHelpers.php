<?php

namespace QI\App\Lib;

use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\View\ArrayData;
use Spatie\Color\Contrast;
use Spatie\Color\Hex;
use TractorCow\Colorpicker\Color;

class ColorHelpers
{
    public static function color($name): ?Color
    {
        $fieldName = $name . 'Color';
        $siteConfig = SiteConfig::current_site_config();
        if ($siteConfig->hasField($fieldName)) {
            return DBField::create_field('Color', ltrim($siteConfig->$fieldName, '#'));
        } else {
            switch ($name) {
                    // *-text-emphasis
                case 'PrimaryTextEmphasis':
                    return self::color('Primary')->Blend(0.4, '#000000');
                case 'SecondaryTextEmphasis':
                    return self::color('Secondary')->Blend(0.4, '#000000');
                case 'SuccessTextEmphasis':
                    return self::color('Success')->Blend(0.4, '#000000');
                case 'InfoTextEmphasis':
                    return self::color('Info')->Blend(0.4, '#000000');
                case 'WarningTextEmphasis':
                    return self::color('Warning')->Blend(0.4, '#000000');
                case 'DangerTextEmphasis':
                    return self::color('Danger')->Blend(0.4, '#000000');
                case 'LightTextEmphasis':
                    return self::color('Dark')->Blend(0.4, '#000000');
                case 'DarkTextEmphasis':
                    return self::color('Dark')->Blend(0.4, '#000000');

                    // *-bg-subtle
                case 'PrimaryBgSubtle':
                    return self::color('Primary')->Blend(0.2, '#ffffff');
                case 'SecondaryBgSubtle':
                    return self::color('Secondary')->Blend(0.2, '#ffffff');
                case 'SuccessBgSubtle':
                    return self::color('Success')->Blend(0.2, '#ffffff');
                case 'InfoBgSubtle':
                    return self::color('Info')->Blend(0.2, '#ffffff');
                case 'WarningBgSubtle':
                    return self::color('Warning')->Blend(0.2, '#ffffff');
                case 'DangerBgSubtle':
                    return self::color('Danger')->Blend(0.2, '#ffffff');
                case 'LightBgSubtle':
                    return DBField::create_field('Color', 'fcfcfd');
                case 'DarkBgSubtle':
                    return DBField::create_field('Color', 'ced4da');

                    // *-border-subtle
                case 'PrimaryBorderSubtle':
                    return self::color('Primary')->Blend(0.4, '#ffffff');
                case 'SecondaryBorderSubtle':
                    return self::color('Secondary')->Blend(0.4, '#ffffff');
                case 'SuccessBorderSubtle':
                    return self::color('Success')->Blend(0.4, '#ffffff');
                case 'InfoBorderSubtle':
                    return self::color('Info')->Blend(0.4, '#ffffff');
                case 'WarningBorderSubtle':
                    return self::color('Warning')->Blend(0.4, '#ffffff');
                case 'DangerBorderSubtle':
                    return self::color('Danger')->Blend(0.4, '#ffffff');
                case 'LightBorderSubtle':
                    return DBField::create_field('Color', 'ced4da');
                case 'DarkBorderSubtle':
                    return DBField::create_field('Color', 'adb5bd');

                    // other
                case 'SecondaryColor':
                    return self::color('Dark')->Blend(0.25, '#ffffff');
                case 'SecondaryBg':
                    return DBField::create_field('Color', 'e9ecef');
                case 'TertiaryColor':
                    return self::color('Dark')->Blend(0.5, '#ffffff');
                case 'TertiaryBg':
                    return DBField::create_field('Color', 'f8f9fa');
                case 'BodyColor':
                    return self::color('Dark');

                case 'White':
                    return DBField::create_field('Color', 'ffffff');
                case 'Black':
                    return DBField::create_field('Color', '000000');
            }
        }
        return null;
    }

    public static function color_hex($name): ?string
    {
        $color = self::color($name);
        if ($color) {
            return '#' . $color->__toString();
        }
        return null;
    }
    public static function color_rgb_vals($name): ?string
    {
        $color = self::color($name);
        if ($color) {
            return "{$color->Red()}, {$color->Green()}, {$color->Blue()}";
        }
        return null;
    }

    public static function contrasting_text($bgColorName): ?ArrayData
    {
        $bg = self::color($bgColorName);
        if (!$bg) {
            return null;
        }
        $bg = '#' . $bg;
        $light = '#' . self::color('Light');
        $dark = '#' . self::color('Dark');
        $white = '#ffffff';
        $black = '#000000';
        $bgColor = Hex::fromString($bg);
        $ratings = [];
        $ratios = [];
        $options = [
            'light' => $light,
            'dark'  => $dark,
            'white' => $white,
            'black' => $black,
        ];
        // find the first, best contrast match
        foreach ($options as $name => $color) {
            $textColor = Hex::fromString($color);
            $ratio = Contrast::ratio($bgColor, $textColor);
            $ratios[$name] = $ratio;
            $ratings[$name] = Helpers::wcag_contrast_rating($ratio);
        }
        $best = array_search('aaa', $ratings);
        if (!$best) {
            $best = array_search('aa', $ratings);
        }
        if (!$best) {
            $best = array_search('aa-large', $ratings);
        }
        if (!$best) {
            arsort($ratios);
            $best = $ratios[0];
        }
        return ArrayData::create([
            'CssClass'      => "text-{$best}",
            'CssColor'      => $options[$best],
            'Rating'        => $ratings[$best],
            'ContrastRatio' => $ratios[$best],
        ]);
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
