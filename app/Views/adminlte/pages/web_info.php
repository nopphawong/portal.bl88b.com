<?= $this->extend("adminlte/layouts/basic") ?>

<?= $this->section("content") ?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="text-center">Web info</h1>
            </div>
        </div>
    </div>
</section>

<section class="content" id="web-info-box">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <form class="card card-default" @submit="submit">
                    <div class="card-header">

                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="d-flex justify-content-center mb-3">
                                <img :src="form.logo_new || form.logo" style="max-width: 250px; max-height: 100px;" />
                            </div>
                            <div class="input-group">
                                <input type="file" id="web_logo" class="form-control" placeholder="Logo" accept="image/png, image/jpeg" @change="onFileChange" :disabled="mode.active == mode.display" />
                                <span class="input-group-append">
                                    <button type="button" class="btn btn-warning btn-flat" @click="removeImage" :disabled="mode.active == mode.display">Remove</button>
                                </span>
                            </div>
                        </div>
                        <hr />
                        <div class="form-group">
                            <label>Domain</label>
                            <input type="url" class="form-control" placeholder="https://xxxx.xxx" v-model="form.url" :disabled="mode.active == mode.display" />
                        </div>
                        <div class="form-group">
                            <label>Site name</label>
                            <input type="text" class="form-control" placeholder="Site name" v-model="form.name" :disabled="mode.active == mode.display" />
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" class="form-control" placeholder="Description" v-model="form.description" :disabled="mode.active == mode.display" />
                        </div>
                        <div class="form-group">
                            <label>Line official</label>
                            <input type="text" class="form-control" placeholder="Line official" v-model="form.line" :disabled="mode.active == mode.display" />
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-end gap-1">
                            <button v-if="mode.active == mode.display" type="button" class="btn btn-primary" @click="mode.active = mode.edit" :disabled="loading">
                                <span>Edit</span>
                            </button>
                            <button v-if="mode.active == mode.edit" type="submit" class="btn btn-primary" style="margin-right: .25rem;" :disabled="loading">
                                <span>Save</span>
                            </button>
                            <button v-if="mode.active == mode.edit" type="button" class="btn btn-outline-secondary" @click="info" :disabled="loading">
                                <span>Cancel</span>
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
                    logo: ``,
                    logo_new: ``,
                    url: ``,
                    name: ``,
                    description: ``,
                    line: ``,
                },
            }
        },
        methods: {
            async info(e) {
                e?.preventDefault()
                this.loading = true
                let { status, message, data } = await post(`web/info`)
                this.loading = false
                if (!status) return showAlert.warning(message)
                this.form.logo = data.logo
                this.form.url = data.url
                this.form.name = data.name
                this.form.description = data.description
                this.form.line = data.line

                this.mode.active = this.mode.display
                this.removeImage(e)
            },
            async submit(e) {
                e?.preventDefault()
                this.loading = true
                let { status, message, data } = await post(`web/info/update`, this.form)
                this.loading = false
                if (!status) return showAlert.warning(message)
                return showAlert.success(message, () => {
                    this.info(e)
                })
            },
            onFileChange(e) {
                e?.preventDefault()
                var files = e.target.files || e.dataTransfer.files
                if (!files.length) return
                this.createImage(files[0])
            },
            createImage(file) {
                var image = new Image()
                var reader = new FileReader()
                var vm = this

                reader.onload = (e) => {
                    vm.form.logo_new = e.target.result
                };
                reader.readAsDataURL(file)
            },
            removeImage: function(e) {
                e?.preventDefault()
                this.form.logo_new = ``
                $("#web_logo").val(``)
            }
        },
        mounted() {
            this.info()
        }
    }).mount('#web-info-box')
</script>

<?= $this->endSection() ?>