<?php

namespace PHPView;

include __DIR__ . '/../PHPSystem/System.php';

use \PHPTemplater\Template;
use \PHPExceptionHandler\ExceptionHandler;
use \PHPSystem\System;

class View {
    public static function create(Template $template, string $content) {
        if (System::isNull($template) || System::isNull($content)) {
            ExceptionHandler::generateError("Невозможно сгенерировать View из пустых значений");
        }

        $content = str_ends_with($content, ".html") ? file_get_contents($content) : $content;
        $view = $template->generatePage($content);

        return $view;
    }

    public static function createFromTemplate(Template $template) {
        if (System::isNull($template)) {
            ExceptionHandler::generateError("Невозможно сгенерировать View из пустых значений");
        }

        $view = $template->generatePage("");

        return $view;
    }

    public static function createFromContent(string $content) {
        if (System::isNull($content)) {
            ExceptionHandler::generateError("Невозможно сгенерировать View из пустых значений");
        }

        $content = str_ends_with($content, ".html") ? file_get_contents($content) : $content;
        $view = $content;

        return $view;
    }
}
