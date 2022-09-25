<?php

include __DIR__ . '/app/PHPRouter/Router.php';
include __DIR__ . '/app/PHPOrm/MySQL.php';
include __DIR__ . '/app/PHPTemplater/Template.php';
include __DIR__ . '/app/PHPView/View.php';

use PHPRouter\Router;
use PHPTemplater\Template;
use PHPView\View;

$router = new Router();

$router->get("test", function() {
    echo "<h3>test</h3>";
    $content = file_get_contents(__DIR__ . "/file.txt");
    if ($content != null) {
        echo $content;
    } else {
        echo "Не удалось прочитать файл";
    }
});

$router->post("test", function() {
    var_dump($_FILES);
    move_uploaded_file($_FILES["file"]["tmp_name"], "file.txt");
});

$router->get("/", function() {
    $template = new Template(__DIR__ . '/pages/editor.html');
    echo View::createFromTemplate($template);
});

$router->exec();