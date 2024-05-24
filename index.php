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
/*
 * list of repositories
 * */
$commentRepo = new Repositories\Comment\CommentRepository();
$newsRepo = new Repositories\News\NewsRepository($commentRepo);


/*
 * Create Object Instance
 * News::class
 * Comment::class
 * */
$newsList = Controllers\NewsManager::getInstance($newsRepo)->list();
$comments = Controllers\CommentManager::getInstance($commentRepo);

foreach ($newsList as $news) {
	echo("############ NEWS " . $news->getTitle() . " ############\n");
	echo($news->getBody() . "\n");
	echo "<br>";

	foreach ($comments->getComments($news->getId()) as $comment) {
        echo("Comment " . $comment['id'] . " : " . $comment['body'] . "\n");
        echo "<br>";
	}
}