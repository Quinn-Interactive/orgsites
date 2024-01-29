<?php

// admin_email

use SilverStripe\Control\Email\Email;
use SilverStripe\Core\Config\Config;
use SilverStripe\Core\Environment;

$qi_admin_email = Environment::getEnv('QI_ADMIN_EMAIL');
$qi_admin_email_name = Environment::getEnv('QI_ADMIN_EMAIL_NAME');

if ($qi_admin_email) {
    if ($qi_admin_email_name) {
        Config::modify()->set(Email::class, 'admin_email', [$qi_admin_email => $qi_admin_email_name]);
    } else {
        Config::modify()->set(Email::class, 'admin_email', $qi_admin_email);
    }
}


// add FulltextSearchable
// FulltextSearchable::enable();

// // remove PasswordValidator for SilverStripe 5.0
// $validator = PasswordValidator::create();
// // Settings are registered via Injector configuration - see passwords.yml in framework
// Member::set_password_validator($validator);

// rich text editor config
require_once 'src/TinyMCE/editor-cms.php';
