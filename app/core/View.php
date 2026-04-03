<?php
declare(strict_types=1);

class View
{
    public static function render(string $view, array $data = []): void
    {
        $viewFile = APP_PATH . '/views/' . str_replace('.', '/', $view) . '.php';

        if (!file_exists($viewFile)) {
            http_response_code(500);
            echo 'View not found: ' . htmlspecialchars($viewFile, ENT_QUOTES, 'UTF-8');
            exit;
        }

        extract($data, EXTR_SKIP);
        require $viewFile;
    }
}