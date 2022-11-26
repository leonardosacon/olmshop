<?php 

require_once("vendor/autoload.php");

use \Slim\Slim;
use \Olmshop\Page;
use \Olmshop\PageAdmin;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function() {

	$page = new Page();

	$page->setTpl("index");

});

$app->get('/admin', function() {

	$pageadmin = new PageAdmin();

	$pageadmin->setTpl("index");

});

$app->run();

?>