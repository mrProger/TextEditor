<?php

include __DIR__ . '/app/PHPRouter/Router.php';
include __DIR__ . '/app/PHPOrm/MySQL.php';
include __DIR__ . '/app/PHPTemplater/Template.php';
include __DIR__ . '/app/PHPView/View.php';

use PHPRouter\Router;
use PHPTemplater\Template;
use PHPView\View;
use PHPExceptionHandler\ExceptionHandler;
use PHPSystem\System;

$router = new Router();

$router->post("load-file", function() {
    session_start();
    $dir = __DIR__ . '/files';

    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    move_uploaded_file($_FILES["file"]["tmp_name"], "$dir/" . $_FILES["file"]["name"]);
    $_SESSION["file"] = "$dir/" . $_FILES["file"]["name"];
    $_SESSION["filename"] = $_FILES["file"]["name"];

    echo "<script>document.location = 'editor'</script>";
});

$router->post("get-file-name", function() {
    session_start();
    echo $_SESSION["filename"];

    $_SESSION["file"] = null;
    $_SESSION["filename"] = null;
});

$router->post("save-file", function() {
    session_start();
    if (!isset($_SESSION["file"]) || $_SESSION["file"] == null) {
        echo "<script>document.location = '/'</script>";
    }

    $data = $GLOBALS["router"]->getPostRouteData();

    if (!isset($data["text"])) {
        ExceptionHandler::generateError("JSON должен содержать поле text");
    }

    file_put_contents($_SESSION["file"], $data["text"]);

    echo "Файл успешно сохранен!";
});

$router->post("read-file", function() {
    session_start();

    if (System::isNull($_SESSION["file"])) {
        echo "<script>document.location = ''</script>";
    }

    $content = file_get_contents($_SESSION["file"]);

    if ($content == null) {
        ExceptionHandler::generateError("Не удалось прочитать загруженный файл");
    }

    echo $content;
});

$router->get("editor", function() {
    $template = new Template(__DIR__ . '/pages/editor.html');
    echo View::createFromTemplate($template);
    echo $GLOBALS["filename"];
});

$router->get("/", function() {
    $template = new Template(__DIR__ . '/pages/index.html');
    echo View::createFromTemplate($template);
});

$router->exec();