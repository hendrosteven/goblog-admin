<?php
require 'vendor/autoload.php';

define('DOMPDF_ENABLE_AUTOLOAD', false);

//load Fatfree
$f3 = Base::instance();

//set config files
$f3->config('settings/config.ini');
$f3->config('settings/routes.ini');

$f3->run();
