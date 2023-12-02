<?= $this->extend("adminlte/layouts/basic") ?>

<?= $this->section("content") ?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="text-center">Wheel info</h1>
            </div>
        </div>
    </div>
</section>

<section class="content" id="wheel-info-box">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <form class="card card-default" @submit="submit">
                    <div class="card-header d-flex align-items-baseline"></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" placeholder="Title" v-model="form.title" :disabled="mode.active == mode.display" />
                        </div>
                        <div class="form-group">
                            <label class="form-label">Description</label>
                            <input type="text" class="form-control" placeholder="Description" v-model="form.detail" :disabled="mode.active == mode.display" />
                        </div>
                        <div class="form-group">
                            <label class="form-label">Deposit rules</label>
                            <input type="text" class="form-control" placeholder="Deposit rules" v-model="form.deposit_rule" :disabled="mode.active == mode.display" />
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-end gap-1">
                            <button v-if="mode.active == mode.display" type="button" class="btn btn-primary" @click="mode.active = mode.edit" :disabled="loading">
                                <i class="fa fa-wrench"></i> <span>Edit</span>
                            </button>
                            <button v-if="mode.active == mode.edit" type="submit" class="btn btn-success" style="margin-right: .25rem;" :disabled="loading">
                                <i class="fa fa-save"></i> <span>Save</span>
                            </button>
                            <button v-if="mode.active == mode.edit" type="button" class="btn btn-outline-secondary" @click="info" :disabled="loading">
                                <i class="fa fa-ban"></i> <span>Cancel</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-3"></div>
        </div>
    </div>
</section>


<script>
    Vue.createApp({
        data() {
            return {
                loading: false,
                mode: {
                    active: ``,
                    edit: `edit`,
                    display: `display`,
                },
                form: {
                    id: ``,
                    title: ``,
                    detail: ``,
                    deposit_rule: ``,
                },
            }
        },
        methods: {
            async info(e) {
                e?.preventDefault()
                this.loading = true
                let { status, message, data } = await post(`wheel/first`)
                this.loading = false
                if (!status) return showAlert.warning(message)

                let { id, title, detail, deposit_rule } = data
                this.form = { id, title, detail, deposit_rule }

                this.mode.active = this.mode.display
                this.removeImage(e)
            },
            async submit(e) {
                e?.preventDefault()
                this.loading = true
                let { status, message, data } = await post(`wheel/info/update`, this.form)
                this.loading = false
                if (!status) return showAlert.warning(message)
                return showAlert.success(message, () => {
                    this.info(e)
                })
            },
        },
        mounted() {
            this.info()
        }
    }).mount('#wheel-info-box')
</script>

<?= $this->endSection() ?>