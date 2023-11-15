<?php

// Load config
require_once 'config/config.php';

// Load Libraries

// the first way
// require_once 'libraries/core.php';
// require_once 'libraries/controller.php';
// require_once 'libraries/database.php';

/* 
 * the second one (best practice)
 * for this to work file name should match the class name exactly
 * ex: class name = Controller 
 * then the file name should have a capital C as well
*/

// Autoload Core  Libraries
spl_autoload_register(function($className){
    require_once 'libraries/' . $className . '.php';
});