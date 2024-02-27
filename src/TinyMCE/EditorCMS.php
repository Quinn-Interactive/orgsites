<?php

namespace QuinnInteractive\Orgsite\TinyMCE;

use Page;
use SilverStripe\Dev\Debug;
use SilverStripe\Forms\HTMLEditor\TinyMCEConfig;
use SilverStripe\SiteConfig\SiteConfig;

class EditorCMS {
    public static function init() {
        $spacing_items = [];
        $spacing_types = [
            'm' => 'margin',
            'p' => 'padding',
        ];
        $spacing_dims = [
            'all' => 'all',
            't'   => 'top',
            'b'   => 'bottom',
            's'   => 'start (left)',
            'e'   => 'end (right)',
            'x'   => 'left & right',
            'y'   => 'top & bottom',
        ];
        $spacing_sizes = [
            0 => '0',
            1 => '0.25rem',
            2 => '0.5rem',
            3 => '1rem',
            4 => '1.5rem',
            5 => '3rem',
        ];

        foreach ($spacing_types as $type_key => $type_label) {
            foreach ($spacing_dims as $dim_key => $dim_label) {
                $items = [];
                foreach ($spacing_sizes as $size_key => $size_label) {
                    $dim = $dim_key == 'all' ? '' : $dim_key;
                    // $size = parse_str($size_key);
                    $classes = "{$type_key}{$dim}-{$size_key}";
                    $items[] = ['title' => "{$type_label} {$dim_label} {$size_label}", 'classes' => $classes, 'selector' => '*'];
                }
                $spacing_items[] = ['title' => "{$type_label} {$dim_label}", 'items' => $items];
            }
        }

        $formats = [
            [
                'title' => 'Text Sizes',
                'items' => [
                    [
                        'title'    => 'Small',
                        'classes'  => 'fs-7',
                        'selector' => '*', // If no text is selected but cursor is within one of these elements, apply class to element
                    ],
                    [
                        'title'    => 'Normal',
                        'classes'  => 'fs-6',
                        'selector' => '*', // If no text is selected but cursor is within one of these elements, apply class to element
                    ],
                    [
                        'title'    => 'h5 size',
                        'classes'  => 'fs-5',
                        'selector' => '*', // If no text is selected but cursor is within one of these elements, apply class to element
                    ],
                    [
                        'title'    => 'h4 size',
                        'classes'  => 'fs-4',
                        'selector' => '*', // If no text is selected but cursor is within one of these elements, apply class to element
                    ],
                    [
                        'title'    => 'h3 size',
                        'classes'  => 'fs-3',
                        'selector' => '*', // If no text is selected but cursor is within one of these elements, apply class to element
                    ],
                    [
                        'title'    => 'h2 size',
                        'classes'  => 'fs-2',
                        'selector' => '*', // If no text is selected but cursor is within one of these elements, apply class to element
                    ],
                    [
                        'title'    => 'h1 size',
                        'classes'  => 'fs-1',
                        'selector' => '*', // If no text is selected but cursor is within one of these elements, apply class to element
                    ],
                    [
                        'title'    => 'Display 1',
                        'classes'  => 'display-1',
                        'selector' => '*', // If no text is selected but cursor is within one of these elements, apply class to element
                    ],
                    [
                        'title'    => 'Display 2',
                        'classes'  => 'display-2',
                        'selector' => '*', // If no text is selected but cursor is within one of these elements, apply class to element
                    ],
                    [
                        'title'    => 'Display 3',
                        'classes'  => 'display-3',
                        'selector' => '*', // If no text is selected but cursor is within one of these elements, apply class to element
                    ],
                    [
                        'title'    => 'Display 4',
                        'classes'  => 'display-4',
                        'selector' => '*', // If no text is selected but cursor is within one of these elements, apply class to element
                    ],
                    [
                        'title'    => 'Display 5',
                        'classes'  => 'display-5',
                        'selector' => '*', // If no text is selected but cursor is within one of these elements, apply class to element
                    ],
                    [
                        'title'    => 'Display 6',
                        'classes'  => 'display-6',
                        'selector' => '*', // If no text is selected but cursor is within one of these elements, apply class to element
                    ],
                ],
            ],
            [
                'title' => 'Heading Styles',
                'items' => [
                    [
                        'title'    => 'h6 style',
                        'classes'  => 'h6',
                        'selector' => '*', // If no text is selected but cursor is within one of these elements, apply class to element
                    ],
                    [
                        'title'    => 'h5 style',
                        'classes'  => 'h5',
                        'selector' => '*', // If no text is selected but cursor is within one of these elements, apply class to element
                    ],
                    [
                        'title'    => 'h4 style',
                        'classes'  => 'h4',
                        'selector' => '*', // If no text is selected but cursor is within one of these elements, apply class to element
                    ],
                    [
                        'title'    => 'h3 style',
                        'classes'  => 'h3',
                        'selector' => '*', // If no text is selected but cursor is within one of these elements, apply class to element
                    ],
                    [
                        'title'    => 'h2 style',
                        'classes'  => 'h2',
                        'selector' => '*', // If no text is selected but cursor is within one of these elements, apply class to element
                    ],
                    [
                        'title'    => 'h1 style',
                        'classes'  => 'h1',
                        'selector' => '*', // If no text is selected but cursor is within one of these elements, apply class to element
                    ],
                ],
            ],
            [
                'title' => 'Colors',
                'items' => [
                    [
                        'title'    => 'Primary (brand)',
                        'classes'  => 'text-primary',
                        'selector' => '*',
                        'inline'   => 'span',
                    ],
                    [
                        'title'    => 'Secondary (secondary)',
                        'classes'  => 'text-secondary',
                        'selector' => '*',
                        'inline'   => 'span',
                    ],
                    [
                        'title'    => 'Info (info)',
                        'classes'  => 'text-info',
                        'selector' => '*',
                        'inline'   => 'span',
                    ],
                    [
                        'title'    => 'Warning (warning)',
                        'classes'  => 'text-warning',
                        'selector' => '*',
                        'inline'   => 'span',
                    ],
                    [
                        'title'    => 'Danger (danger)',
                        'classes'  => 'text-danger',
                        'selector' => '*',
                        'inline'   => 'span',
                    ],
                    [
                        'title'    => 'Light (light)',
                        'classes'  => 'text-light',
                        'selector' => '*',
                        'inline'   => 'span',
                    ],
                    [
                        'title'    => 'Dark (dark)',
                        'classes'  => 'text-dark',
                        'selector' => '*',
                        'inline'   => 'span',
                    ],

                    [
                        'title'    => 'Background Primary (brand)',
                        'classes'  => 'bg-primary',
                        'selector' => '*',
                        'inline'   => 'span',
                    ],
                    [
                        'title'    => 'Background Secondary (secondary)',
                        'classes'  => 'bg-secondary',
                        'selector' => '*',
                        'inline'   => 'span',
                    ],
                    [
                        'title'    => 'Background Cyan (info)',
                        'classes'  => 'bg-info',
                        'selector' => '*',
                        'inline'   => 'span',
                    ],
                    [
                        'title'    => 'Background Yellow (warning)',
                        'classes'  => 'bg-warning',
                        'selector' => '*',
                        'inline'   => 'span',
                    ],
                    [
                        'title'    => 'Background Red (danger)',
                        'classes'  => 'bg-danger',
                        'selector' => '*',
                        'inline'   => 'span',
                    ],
                    [
                        'title'    => 'Background Light Gray (light)',
                        'classes'  => 'bg-light',
                        'selector' => '*',
                        'inline'   => 'span',
                    ],
                    [
                        'title'    => 'Background Dark Gray (dark)',
                        'classes'  => 'bg-dark',
                        'selector' => '*',
                        'inline'   => 'span',
                    ],

                ],
            ],
            [
                'title' => 'Spacing',
                'items' => $spacing_items,
            ],

            [
                'title' => 'Button Styles',
                'items' => [

                    [
                        'title'      => 'Button (primary)',
                        'attributes' => ['class' => 'btn btn-primary'],
                        'selector'   => 'a', // If no text is selected but cursor is within one of these elements, apply class to element
                    ],
                    [
                        'title'      => 'Button (secondary)',
                        'attributes' => ['class' => 'btn'],
                        'selector'   => 'a', // If no text is selected but cursor is within one of these elements, apply class to element
                    ],
                ],
            ],

        ];

        /** @var TinyMCEConfig */
        $config = TinyMCEConfig::get('cms');

        // add the charmap plugin for some special characters
        $config->enablePlugins(['charmap', 'hr']);

        // CMS editor styles
        $config->setOptions([
            'importcss_append'              => true,
            'style_formats_autohide'        => true,
            'style_formats'                 => $formats,
            'body_class'                    => 'typography',
            'schema'                        => 'html5',
            'paste_auto_cleanup_on_paste'   => true,
            'paste_remove_styles'           => true,
            'paste_remove_styles_if_webkit' => true,
            'paste_strip_class_attributes'  => true,
            'theme_advanced_blockformats'   => 'p,address,pre,h1,h2,h3,h4,h5,h6',
        ]);
        $config->addButtonsToLine(1, 'styles');
        $valid_elements = $config->getOption('valid_elements');
        // add some more valid elements
        $valid_elements .= ',-kbd[id|dir|class|align|style],-samp[id|dir|class|align|style]';
        $config->setOption('valid_elements', $valid_elements);
        $config->addButtonsToLine(2, 'styleselect'); // add style select
        // TinyMCE cleanup on paste
        // add removeformat
        $config->insertButtonsBefore('selectall', 'removeformat');
        // add charmap
        $config->insertButtonsBefore('anchor', 'charmap');
        $config->insertButtonsAfter('anchor', 'hr');

        // use our calculated themed CSS
        $siteConfig = SiteConfig::current_site_config();
        if ($siteConfig) {
            $fontsImport = $siteConfig->FontHeadCode('import');
            $themeVars = Page::create()->renderWith('QuinnInteractive/Orgsite/Includes/ThemeVars')->__toString();
            $themeVars = preg_replace('@</?style>@', '', $themeVars);
            $customStyles = $fontsImport . "\n" .  $themeVars;
            $config->setOption('content_style', $customStyles);
        }        
    }
}

