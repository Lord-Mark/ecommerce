<?php

require_once 'vendor/autoload.php';

use \Slim\Slim;
use \Website\Page;
use \Website\Model\User;

session_start();
$app = new Slim();

$app->config("debug", true);

/**
* Função chamada na raiz da url
*/

$app->get("/", function ()
{
	$page = new Page;
	$page->setTpl("index");
	exit;
});

/**
* Página para admins
*/

$app->get("/admin", function ()
{
	User::verifyLogin();

	$page = new Page(array(), "views/admin/");
	$page->setTpl("index");

});

/**
* Logar admins
*/

$app->get("/admin/login", function ()
{
	$page = new Page(
		array(

			"header" => false,
			"footer" => false

		), "views/admin/"
	);
	$page->setTpl("login");
	exit;
});

/**
* Login de admins
*/
$app->post("/admin/login", function()
{
	User::login($_POST["login"], $_POST['password']);

	header("Location: /admin");
	exit;
	
	#echo password_hash('789456', PASSWORD_DEFAULT);
});

/**
* Logout de admins
*/
$app->get("/admin/logout", function()
{
	User::logout();
	header("Location: /admin/login");
	exit;
});

/**
* Lista usuários na página de admins
*/
$app->get("/admin/users", function(){

	User::verifyLogin();

	$users = User::listAll();

	$page = new Page(array(), "views/admin/");
	$page->setTpl("users", array(
		"users"=>$users
	));
	exit;
});

/**
* Cria usuários
*/
$app->get("/admin/users/create", function(){

	User::verifyLogin();

	$page = new Page(array(), "views/admin/");
	$page->setTpl("users-create");
	exit;
});

/**
* Deleta usuários
*/

$app->get("/admin/users/:iduser/delete", function($iduser){
	
	User::verifyLogin();
	
	$user = new User();

	$user->get($iduser);

	$user->delete();

	header("Location: /admin/users");
	exit;
});

/**
* Edita dados de um usuário
*/
$app->get("/admin/users/:iduser", function($iduser){

	User::verifyLogin();

	$user = new User();

	$user->get((int)$iduser);

	$page = new Page(array(), "views/admin/");
	$page->setTpl("users-update", array(
		"user" => $user->getData()
	));
	exit;
});

/**
* Recebe as edições do usuário e insere no banco
*/
$app->post("/admin/users/:iduser", function($iduser){
	
	User::verifyLogin();

	$_POST['inadmin'] = $_POST['inadmin'] ?? 0;
	
	$user = new User();
	$user->get((int)$iduser);
	$user->setData($_POST);
	$user->update($iduser);
	
	header("Location: /admin/users");
	exit;
});

/**
* Cria usuários
*/
$app->post("/admin/users/create", function(){
	
	User::verifyLogin();

	$user = new User();

	//caso a opção inadmin não tenha sido marcada, então será setado como 0; 
	//operador de coalescência nula 

	$_POST['inadmin'] = $_POST['inadmin'] ?? 0;

	$user->setData($_POST);

	$user->insert();

	header("Location: /admin/users");
	exit;
});

$app->run();