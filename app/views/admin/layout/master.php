<?php
declare(strict_types=1);

$adminTheme = (string) Config::get('themes.admin_theme', 'default');
$themeLayout = APP_PATH . '/views/themes/admin/' . $adminTheme . '/layout.php';

if (!file_exists($themeLayout)) {
    throw new RuntimeException('Admin theme layout not found: ' . $themeLayout);
}

require $themeLayout;