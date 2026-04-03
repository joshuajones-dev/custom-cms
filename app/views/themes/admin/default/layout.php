<?php
declare(strict_types=1);

$siteName = (string) ($siteName ?? Config::get('cms.site_name', 'My CMS Site'));
$pageTitle = (string) ($pageTitle ?? 'Admin');
$pageHeading = (string) ($pageHeading ?? 'Admin');
$pageIntro = (string) ($pageIntro ?? '');
$adminNav = (string) ($adminNav ?? 'dashboard');
$breadcrumbs = is_array($breadcrumbs ?? null) ? $breadcrumbs : [];
$bodyClass = trim((string) ($bodyClass ?? ''));

if (empty($contentView) || !is_file($contentView)) {
    throw new RuntimeException('Admin content view not found.');
}

require __DIR__ . '/partials/head.php';
?>
<body class="<?= htmlspecialchars($bodyClass, ENT_QUOTES, 'UTF-8'); ?>">
<section class="body">
    <?php require __DIR__ . '/partials/header.php'; ?>

    <div class="inner-wrapper">
        <?php require __DIR__ . '/partials/sidebar.php'; ?>

        <section role="main" class="content-body">
            <?php require __DIR__ . '/partials/page-header.php'; ?>

            <div class="cms-admin-content-wrap">
                <?php require __DIR__ . '/partials/alerts.php'; ?>
                <?php require $contentView; ?>
            </div>

            <?php require __DIR__ . '/partials/footer.php'; ?>
        </section>
    </div>
</section>

<?php require __DIR__ . '/partials/scripts.php'; ?>
</body>
</html>