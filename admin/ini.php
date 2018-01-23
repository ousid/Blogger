<?php 

define('ROOT', realpath(__DIR__));

require_once 'includes/functions/functions.php';
require_once 'includes/template/head.php';
require_once 'core/connection.php';

global $nav;

if(isset($nav)) {
    require_once 'includes/template/nav.php';
}