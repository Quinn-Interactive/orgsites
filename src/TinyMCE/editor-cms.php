<?php

namespace QuinnInteractive\Orgsite\TinyMCE;

use SilverStripe\Core\Manifest\ModuleResourceLoader;
use SilverStripe\Forms\HTMLEditor\HTMLEditorConfig;
use SilverStripe\Forms\HTMLEditor\TinyMCEConfig;


/** @var TinyMCEConfig */
$config = HTMLEditorConfig::get('cms');

// add the charmap plugin for some special characters
$config->enablePlugins(['charmap', 'hr']);

// CMS editor styles
$config->setOptions([
    'importcss_append' => true,
    'style_formats_autohide' => false,
    // 'style_formats' => $formats,
    'body_class' => 'typography',
    'schema' => 'html5',
    'paste_auto_cleanup_on_paste' => true,
    'paste_remove_styles' => true,
    'paste_remove_styles_if_webkit' => true,
    'paste_strip_class_attributes' => true,
    'theme_advanced_blockformats' => 'p,address,pre,h1,h2,h3,h4,h5,h6',
]);
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
