<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 Server Error</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; padding: 40px; }
    </style>
</head>
<body>
    <h1>500 Server Error</h1>
    <p>Something went wrong while loading the application.</p>
    <?php if (!empty($message)): ?>
        <p><strong>Message:</strong> <?= htmlspecialchars((string) $message, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>
    <p><a href="<?= htmlspecialchars(ROOT, ENT_QUOTES, 'UTF-8'); ?>">Return Home</a></p>
</body>
</html>