<?php
require 'vendor/autoload.php';

//load Fatfree
$f3 = Base::instance();

//set config files
$f3->config('settings/config.ini');
$f3->config('settings/routes.ini');

$f3->run();
