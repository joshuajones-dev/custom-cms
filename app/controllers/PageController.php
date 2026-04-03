<?php
declare(strict_types=1);

class PageController extends Controller
{
    protected PageService $pageService;

    public function __construct()
    {
        parent::__construct();
        $this->pageService = new PageService();
    }

    public function index(): void
    {
        $data = [
            'pageTitle' => 'Pages' . WEBSITE_TITLE,
            'siteName'  => Config::get('cms.site_name', 'My CMS Site'),
            'pages'     => $this->pageService->all(),
            'success'   => $this->session->getFlash('success'),
        ];

        $this->view('admin.pages.index', $data);
    }

    public function create(): void
    {
        $errors = [];
        $form = [
            'title'   => '',
            'slug'    => '',
            'content' => '',
            'status'  => 'draft',
            'template'=> 'default',
        ];

        if ($this->request->isPost()) {
            $form = [
                'title'    => (string) $this->request->input('title', ''),
                'slug'     => (string) $this->request->input('slug', ''),
                'content'  => (string) $this->request->input('content', ''),
                'status'   => (string) $this->request->input('status', 'draft'),
                'template' => (string) $this->request->input('template', 'default'),
            ];

            $errors = $this->pageService->validate($form);

            if (empty($errors)) {
                $page = $this->pageService->create($form);
                $this->session->flash('success', 'Page created successfully.');
                redirect('admin/pages/edit/' . urlencode((string) $page['id']));
            }
        }

        $data = [
            'pageTitle' => 'Add Page' . WEBSITE_TITLE,
            'siteName'  => Config::get('cms.site_name', 'My CMS Site'),
            'form'      => $form,
            'errors'    => $errors,
            'isEdit'    => false,
        ];

        $this->view('admin.pages.form', $data);
    }

    public function show(): void
    {
        $slug = trim((string) $this->request->route('slug', ''));
        $page = $this->pageService->findBySlug($slug);

        if (!$page || ($page['status'] ?? 'draft') !== 'published') {
            abort(404, 'Published page not found.');
        }

        $this->renderPage($page);
    }

    protected function renderPage(array $page): void
    {
        $template = trim((string) ($page['template'] ?? 'default'));
        $view = 'themes.default.page';

        if ($template !== '' && file_exists(APP_PATH . '/views/themes/default/page-' . $template . '.php')) {
            $view = 'themes.default.page-' . $template;
        }

        $pageTitle = trim((string) ($page['title'] ?? ''));

        $data = [
            'pageTitle' => $pageTitle . WEBSITE_TITLE,
            'siteName'  => Config::get('cms.site_name', 'My CMS Site'),
            'page'      => $page,
        ];

        $this->view($view, $data);
    }
}