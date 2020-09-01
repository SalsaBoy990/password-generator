<?php

namespace AG\PasswordGenerator;

defined('ABSPATH') or die();

/*
Plugin Name: Secure Password Generator
Plugin URI: https://github.com/SalsaBoy990/secure-password-generator
Description: Secure Password Generator plugin
Version: 0.1
Author: András Gulácsi
Author URI: https://github.com/SalsaBoy990
License: GPLv2 or later
Text Domain: ag-secure-psswrd-gen
Domain Path: /languages
*/

// require all requires once
require_once 'requires.php';

use \AG\PasswordGenerator\PasswordGenerator as PasswordGenerator;

use \AG\PasswordGenerator\Log\KLogger as Klogger;


$ag_password_generator_log_file_path = plugin_dir_path(__FILE__) . '/log';

$ag_password_generator_log = new KLogger($ag_password_generator_log_file_path, KLogger::INFO);

// main class
PasswordGenerator::getInstance();

// we don't need to do anything when deactivation
// register_deactivation_hook(__FILE__, function () {});

register_activation_hook(__FILE__, '\AG\PasswordGenerator\PasswordGenerator::activatePlugin');

// delete options when uninstalling the plugin
register_uninstall_hook(__FILE__, '\AG\PasswordGenerator\PasswordGenerator::uninstallPlugin');
