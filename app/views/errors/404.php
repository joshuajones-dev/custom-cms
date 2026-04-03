<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; padding: 40px; }
    </style>
</head>
<body>
    <h1>404 Not Found</h1>
    <p>The requested path could not be found.</p>
    <p><strong>Path:</strong> <?= htmlspecialchars($path ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
    <p><a href="<?= htmlspecialchars(ROOT, ENT_QUOTES, 'UTF-8'); ?>">Return Home</a></p>
</body>
</html>