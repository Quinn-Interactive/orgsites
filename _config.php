<?php

// admin_email

use QuinnInteractive\Orgsite\ShortCode\NowShortcode;
use QuinnInteractive\Orgsite\ShortCode\SinceShortcode;
use QuinnInteractive\Orgsite\TinyMCE\EditorCMS;
use SilverStripe\Control\Email\Email;
use SilverStripe\Core\Config\Config;
use SilverStripe\Core\Environment;
use SilverStripe\View\Parsers\ShortcodeParser;

$qi_admin_email = Environment::getEnv('QI_ADMIN_EMAIL');
$qi_admin_email_name = Environment::getEnv('QI_ADMIN_EMAIL_NAME');

if ($qi_admin_email) {
    if ($qi_admin_email_name) {
        Config::modify()->set(Email::class, 'admin_email', [$qi_admin_email => $qi_admin_email_name]);
    } else {
        Config::modify()->set(Email::class, 'admin_email', $qi_admin_email);
    }
}

// Shortcodes
ShortcodeParser::get()->register('since', array(SinceShortcode::class, 'shortcode_handler'));
ShortcodeParser::get()->register('now', array(NowShortcode::class, 'shortcode_handler'));



// add FulltextSearchable
// FulltextSearchable::enable();

// // remove PasswordValidator for SilverStripe 5.0
// $validator = PasswordValidator::create();
// // Settings are registered via Injector configuration - see passwords.yml in framework
// Member::set_password_validator($validator);

// rich text editor config
EditorCMS::init();