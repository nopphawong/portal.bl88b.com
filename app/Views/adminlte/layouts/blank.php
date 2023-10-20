<?= $this->extend("adminlte/layouts/document") ?>

<?= $this->section("content") ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <?= $this->renderSection('content') ?>
    </div>

<?= $this->endSection() ?>