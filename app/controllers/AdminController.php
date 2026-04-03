<?php
declare(strict_types=1);

class AdminController extends Controller
{
    protected PageService $pageService;

    public function __construct()
    {
        parent::__construct();
        $this->pageService = new PageService();
    }

    public function index(): void
    {
        $pages = $this->pageService->all();

        $stats = [
            'total_pages'     => count($pages),
            'published_pages' => 0,
            'draft_pages'     => 0,
        ];

        foreach ($pages as $page) {
            $status = strtolower(trim((string) ($page['status'] ?? 'draft')));

            if ($status === 'published') {
                $stats['published_pages']++;
            } else {
                $stats['draft_pages']++;
            }
        }

        usort($pages, static function (array $a, array $b): int {
            return strcmp((string) ($b['updated_at'] ?? ''), (string) ($a['updated_at'] ?? ''));
        });

        $data = [
            'pageTitle'   => 'Admin Dashboard' . WEBSITE_TITLE,
            'siteName'    => Config::get('cms.site_name', 'My CMS Site'),
            'success'     => $this->session->getFlash('success'),
            'stats'       => $stats,
            'recentPages' => array_slice($pages, 0, 5),
        ];

        $this->view('admin.dashboard', $data);
    }
}