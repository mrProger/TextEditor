<?php

include __DIR__ . '/app/PHPRouter/Router.php';
include __DIR__ . '/app/PHPOrm/MySQL.php';
include __DIR__ . '/app/PHPTemplater/Template.php';
include __DIR__ . '/app/PHPView/View.php';

use PHPRouter\Router;
use PHPTemplater\Template;
use PHPView\View;
use PHPExceptionHandler\ExceptionHandler;

$router = new Router();

$router->post("load-file", function() {
    move_uploaded_file($_FILES["file"]["tmp_name"], "file.txt");
    echo "<script>document.location = 'editor'</script>";
});

$router->post("read-file", function() {
    $content = file_get_contents(__DIR__ . "/file.txt");

    if ($content == null) {
        ExceptionHandler::generateError("Не удалось прочитать загруженный файл");
    }

    echo $content;
});

$router->get("editor", function() {
    $template = new Template(__DIR__ . '/pages/editor.html');
    echo View::createFromTemplate($template);
});

$router->get("/", function() {
    $template = new Template(__DIR__ . '/pages/index.html');
    echo View::createFromTemplate($template);
});

$router->exec();