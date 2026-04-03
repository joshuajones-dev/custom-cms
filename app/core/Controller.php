<?php
declare(strict_types=1);

class Controller
{
    protected Request $request;
    protected Response $response;
    protected Session $session;

    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
    }

    protected function view(string $view, array $data = []): void
    {
        View::render($view, $data);
    }

    protected function config(string $key, mixed $default = null): mixed
    {
        return Config::get($key, $default);
    }
}