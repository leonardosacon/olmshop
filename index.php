<?php 
session_start();
require_once("vendor/autoload.php");

use \Slim\Slim;
use \Olmshop\Page;
use \Olmshop\PageAdmin;
use \Olmshop\Model\User;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function() {

	$page = new Page();

	$page->setTpl("index");

});

$app->get('/admin', function() {

	User::verifyLogin();

	$pageadmin = new PageAdmin();

	$pageadmin->setTpl("index");

});

$app->get('/admin/login', function() {

	$pageadmin = new PageAdmin([
		"header" => false,
		"footer" => false
	]);

	$pageadmin->setTpl("login");

});

$app->post('/admin/login', function() {

	User::login($_POST['login'], $_POST['password']);

	header("Location: /admin");
	exit;

});

$app->get('/admin/logout', function(){
	
	User::logout();
	
	header("Location: /admin/login");
	exit;
});

$app->run();

?>