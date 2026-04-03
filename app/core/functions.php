<?php
declare(strict_types=1);

if (!function_exists('abort')) {
    function abort(int $code = 404, string $message = ''): never
    {
        http_response_code($code);

        $view = match ($code) {
            403 => 'errors.403',
            404 => 'errors.404',
            default => 'errors.500',
        };

        $data = [];

        if ($code === 404) {
            $data['path'] = $_SERVER['REQUEST_URI'] ?? '';
        }

        if ($message !== '') {
            $data['message'] = $message;
        }

        View::render($view, $data);
        exit;
    }
}

if (!function_exists('redirect')) {
    function redirect(string $path): never
    {
        header('Location: ' . base_url($path));
        exit;
    }
}