<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('CONFIG_PATH', ROOT_PATH . '/config');
define('STORAGE_PATH', ROOT_PATH . '/storage');
define('PUBLIC_PATH', ROOT_PATH . '/public');

$isCli = (PHP_SAPI === 'cli');

if (!defined('DEBUG')) {
    define('DEBUG', true);
}

if (DEBUG) {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
    error_reporting(0);
}

if (!defined('REG')) {
    define('REG', true);
}

if (!defined('SIGNIN')) {
    define('SIGNIN', true);
}

if (!defined('WEBSITE_TITLE')) {
    define('WEBSITE_TITLE', ' | CMS Website Domain Title');
}

if (!defined('PROTOCOL')) {
    if ($isCli) {
        define('PROTOCOL', 'http');
    } else {
        $isHttps = (
            (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || (isset($_SERVER['SERVER_PORT']) && (int) $_SERVER['SERVER_PORT'] === 443)
        );

        define('PROTOCOL', $isHttps ? 'https' : 'http');
    }
}

if (!defined('ROOT')) {
    if ($isCli) {
        define('ROOT', '');
    } else {
        $host = $_SERVER['HTTP_HOST'] ?? ($_SERVER['SERVER_NAME'] ?? 'localhost');
        $scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');

        $basePath = preg_replace('#/public(?:/.*)?$#', '', $scriptName);
        $basePath = is_string($basePath) ? rtrim($basePath, '/') : '';

        define('ROOT', PROTOCOL . '://' . $host . $basePath);
    }
}

if (!defined('ASSETS')) {
    define('ASSETS', ROOT !== '' ? ROOT . '/assets/' : 'public/assets/');
}

require_once APP_PATH . '/core/Config.php';
require_once APP_PATH . '/core/View.php';
require_once APP_PATH . '/core/Controller.php';
require_once APP_PATH . '/core/functions.php';
require_once APP_PATH . '/core/App.php';

require_once APP_PATH . '/middleware/Middleware.php';

require_once APP_PATH . '/services/PageService.php';
$configFiles = [
    'app',
    'cms',
    'database',
    'themes',
    'routes',
];

foreach ($configFiles as $file) {
    Config::set($file, require CONFIG_PATH . '/' . $file . '.php');
}

require_once APP_PATH . '/controllers/HomeController.php';
require_once APP_PATH . '/controllers/AdminController.php';
require_once APP_PATH . '/controllers/PageController.php';