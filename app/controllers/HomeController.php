<?php
declare(strict_types=1);

class HomeController extends Controller
{
    public function index(): void
    {
        $data = [
            'pageTitle' => Config::get('app.name', 'Site CMS') . WEBSITE_TITLE,
            'siteName'  => Config::get('cms.site_name', 'My CMS Site'),
        ];

        $this->view('themes.default.home', $data);
    }
}