<?php
defined('BASEPATH') or exit('No direct script access allowed');

$hook['pre_system'][] = array(
    'class'    => 'MaintinanceHook',
    'function' => 'check_maintenance',
    'filename' => 'MaintinanceHook.php',
    'filepath' => 'hooks'
);


/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/userguide3/general/hooks.html
|
*/
