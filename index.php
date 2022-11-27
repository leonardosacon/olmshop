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

/* USERS - Get Post Delete*/
$app->get('/admin/users', function(){
	User::verifyLogin();

	$pageadmin = new PageAdmin();
	$pageadmin->setTpl("users");
});

$app->get('/admin/users/create', function(){
	User::verifyLogin();
	
	$pageadmin = new PageAdmin();

	$pageadmin->setTpl("users-create");
});

$app->get('/admin/users/:iduser', function($iduser){
	User::verifyLogin();
	
	$pageadmin = new PageAdmin();
	$pageadmin->setTpl("users-update");
});

$app->post("/admin/users/create", function(){
	User::verifyLogin();

	$user = new User();

 	$_POST["inadmin"] = (isset($_POST["inadmin"])) ? 1 : 0;

	if($_POST['despassword'] != $_POST['repeatdespassword']){
		throw new Exception("As senhas não correspondem", 1);
		exit;
	}

 	$_POST['despassword'] = password_hash($_POST["despassword"], PASSWORD_DEFAULT, [

 		"cost"=>12

 	]);

 	$user->setData($_POST);

	$user->save();

	header("Location: /admin/users");
 	exit;
});

$app->post("/admin/users/:iduser", function($iduser){
	User::verifyLogin();
});

$app->delete("/admin/users/:iduser", function($iduser){
	User::verifyLogin();
});
/* USERS final */

$app->run();

?>