<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Site', ENT_QUOTES, 'UTF-8'); ?></title>
    <?php if (!empty($metaDescription)): ?>
        <meta name="description" content="<?= htmlspecialchars((string) $metaDescription, ENT_QUOTES, 'UTF-8'); ?>">
    <?php endif; ?>
    <style>
        body { margin: 0; font-family: Arial, Helvetica, sans-serif; background: #ffffff; color: #222; }
        header, footer { background: #f5f5f5; padding: 20px; }
        main { max-width: 1100px; margin: 30px auto; padding: 0 20px; }
        .card { background: #fff; border: 1px solid #ddd; border-radius: 8px; padding: 24px; }
        a { color: #0d6efd; text-decoration: none; }
        .preview-banner { max-width: 1100px; margin: 20px auto 0; padding: 12px 20px; background: #fff3cd; color: #664d03; border: 1px solid #ffecb5; border-radius: 8px; }
    </style>
</head>
<body>
    <?php if (!empty($isPreview)): ?>
        <div class="preview-banner">Preview Mode — this page may still be in draft.</div>
    <?php endif; ?>
    <?php require __DIR__ . '/partials/header.php'; ?>
    <main>
        <?php require $contentView; ?>
    </main>
    <?php require __DIR__ . '/partials/footer.php'; ?>
</body>
</html>