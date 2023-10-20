<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title) ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <?= link_tag("assets/plugins/fontawesome-free/css/all.min.css") ?>
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <?= link_tag("assets/css/adminlte.min.css") ?>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <?= $this->renderSection('content') ?>

    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <?= script_tag("assets/plugins/jquery/jquery.min.js") ?>
    <!-- Bootstrap 4 -->
    <?= script_tag("assets/plugins/bootstrap/js/bootstrap.bundle.min.js") ?>
    <!-- AdminLTE App -->
    <?= script_tag("assets/js/adminlte.js") ?>

    <!-- OPTIONAL SCRIPTS -->
    <!-- ChartJS -->
    <?= script_tag("assets/plugins/chart.js/Chart.min.js") ?>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <?= script_tag("assets/js/pages/dashboard3.js") ?>
</body>

</html>