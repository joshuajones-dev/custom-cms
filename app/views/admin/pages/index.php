<?php
declare(strict_types=1);

$contentView = __DIR__ . '/index-content.php';
$adminNav = 'pages';
$pageHeading = 'Pages';
$breadcrumbs = [
    ['label' => 'Pages'],
];

require APP_PATH . '/views/admin/layout/master.php';