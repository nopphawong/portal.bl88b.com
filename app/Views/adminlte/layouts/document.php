<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title) ?></title>

    <link rel="shortcut icon" href="<?= base_url() ?>images/favicon.ico" type="image/x-icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <?= link_tag("assets/plugins/fontawesome-free/css/all.min.css") ?>
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <?= link_tag("https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css") ?>
    <?= link_tag("assets/css/adminlte.min.css") ?>
    <?= link_tag("assets/vendors/fonts/boxicons.css") ?>

    <?php foreach ($includes_css as $css) : ?>
        <?= link_tag($css) ?>
    <?php endforeach ?>

    <!-- jQuery -->
    <?= script_tag("assets/plugins/jquery/jquery.min.js") ?>
    <!-- Bootstrap 4 -->
    <?= script_tag("assets/plugins/bootstrap/js/bootstrap.bundle.min.js") ?>
    <!-- AdminLTE App -->
    <?= script_tag("assets/js/adminlte.js") ?>

    <?= script_tag("https://cdn.jsdelivr.net/npm/sweetalert2@11") ?>
    <?= script_tag("https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment-with-locales.min.js") ?>

    <?php foreach ($includes_js as $js) : ?>
        <?= script_tag($js) ?>
    <?php endforeach ?>

    <script src="https://unpkg.com/vue@3.4.21/dist/vue.global.prod.js"></script>
    <?php foreach ($includes_vuejs as $js) : ?>
        <?= script_tag($js) ?>
    <?php endforeach ?>
</head>

<body>
    <div class="wrapper">

        <?= $this->renderSection('content') ?>

    </div>
    <!-- ./wrapper -->

</body>

</html>