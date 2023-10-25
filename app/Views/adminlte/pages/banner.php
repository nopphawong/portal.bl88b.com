<?= $this->extend("adminlte/layouts/basic") ?>

<?= $this->section("content") ?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="text-center">Banners</h1>
            </div>
        </div>
    </div>
</section>

<section class="content" id="banner-box">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header"></div>
                    <div class="card-body">
                        <table id="banner-table"></table>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
    Vue.createApp({
        data() {
            return {
                loading: false,
                table: null,
            }
        },
        methods: {

        },
        mounted() {
            // this.table = $(`#banner-table`).DataTable()
        }
    }).mount('#banner-box')
</script>

<?= $this->endSection() ?>