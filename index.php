<?php 
session_start();

require_once("vendor/autoload.php");
use \Slim\Slim;
use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;


$app = new Slim();

$app->config('debug', true);

$app->get('/', function() {
    
	$page = new Page();

	$page->setTpl("index");

});

$app->get('/admin', function() {
	User::verifyLogin();
    
	$page = new PageAdmin();

	$page->setTpl("index");

});

$app->get('/admin/login', function() {
    //dessa maneira eu estou desabilitando o "header" e o "footer" que são padrão
	$page = new PageAdmin([
		"header" => false,
		"footer" => false
	]);

	$page->setTpl("login");

});

$app->post('/admin/login', function() {
	//se não tive nenhuma exception esse método vai pegar essa duas informações
	User::login($_POST["login"], $_POST["password"]);

	//e vai redirecionar a página para /admin
	header("Location: /admin");
	exit;
});

$app->get('/admin/logout', function() {
	User::logout();

	header("Location: /admin/login");
	exit;
});

$app->run();

 ?>