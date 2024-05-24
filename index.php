<?php
define('ROOT', __DIR__);
//header('Content-Type: application/json; charset=utf-8');
/*
 * Composer initialization
 * autoload the classes
 * */
require_once ROOT . '/vendor/autoload.php';

//spl_autoload_register(function ($className) {
//    $directories = [
//        'interfaces',
//        'class',
//        'utils'
//    ];
//
//    foreach ($directories as $directory) {
//        $filePath = ROOT . "/$directory/$className.php";
//        if (file_exists($filePath)) {
//            require_once($filePath);
//        }
//    }
//});

$newsList = Utils\NewsManager::getInstance()->listNews();
$comments = Utils\CommentManager::getInstance()->listComments();

foreach ($newsList as $news) {
	echo("############ NEWS " . $news->getTitle() . " ############\n");
	echo($news->getBody() . "\n");
	echo "<br>";

	foreach ($comments as $comment) {
		if ($comment->getNewsId() == $news->getId()) {
			echo("Comment " . $comment->getId() . " : " . $comment->getBody() . "\n");
			echo "<br>";
		}
	}
}