<?php
declare(strict_types=1);

$contentView = __DIR__ . '/dashboard-content.php';
$adminNav = 'dashboard';
$pageHeading = 'Dashboard';
$breadcrumbs = [
    ['label' => 'Dashboard'],
];

require APP_PATH . '/views/admin/layout/master.php';