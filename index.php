<?php

require_once 'vendor/autoload.php';

use \Slim\Slim;
use \Website\Page;
use \Website\Model\User;

session_start();
$app = new Slim();

$app->config("debug", true);

$app->get("/", function ()
{
	$page = new Page;
	$page->setTpl("index");
});

$app->get("/admin", function ()
{
	User::verifyLogin();

	$page = new Page(array(), "views/admin/");
	$page->setTpl("index");

});

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

$app->post("/admin/login", function()
{
	User::login($_POST["login"], $_POST['password']);

	header("Location: /admin");
	exit;
	
	#echo password_hash('789456', PASSWORD_DEFAULT);
});

$app->get("/admin/logout", function()
{
	User::logout();
	header("Location: /admin/login");
	exit;
});

$app->run();