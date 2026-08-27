<?php
$tf_title = $tf_title ?? 'The Farmer';
$tf_description = $tf_description ?? 'The Farmer grows healthy citrus in Cameroon.';
$tf_body_class = $tf_body_class ?? '';
$tf_dashboard = !empty($tf_dashboard);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($tf_title) ?></title>
    <meta name="description" content="<?= e($tf_description) ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Nunito+Sans:opsz,wght@6..12,400;6..12,600;6..12,700;6..12,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(asset('fontawesome/css/all.css')) ?>">
    <link rel="stylesheet" href="<?= e(asset('CSS/main.css')) ?>">
    <?php if ($tf_dashboard): ?>
    <link rel="stylesheet" href="<?= e(asset('CSS/dashboard.css')) ?>">
    <?php endif; ?>
    <link rel="shortcut icon" href="<?= e(asset('Image/RO.png')) ?>" type="image/png">
    <script>
      window.TF_BASE = <?= json_encode(BASE_URL) ?>;
      window.TF_ASSET = <?= json_encode(ASSET_URL) ?>;
      window.TF_CSRF = <?= json_encode(csrf_token()) ?>;
      window.TF_LOGGED_IN = <?= json_encode(is_logged_in()) ?>;
      window.TF_PROCESS = <?= json_encode(url('process.php')) ?>;
      window.TF_CATALOG = <?= json_encode(Product::catalogForJs()) ?>;
    </script>
    <script>(function(){try{var t=localStorage.getItem('tf-theme')||(matchMedia('(prefers-color-scheme: dark)').matches?'dark':'light');document.documentElement.setAttribute('data-theme',t);}catch(e){document.documentElement.setAttribute('data-theme','light');}})();</script>
</head>
<body<?= $tf_body_class !== '' ? ' class="' . e($tf_body_class) . '"' : '' ?>>
