<?= $this->extend("adminlte/layouts/basic") ?>

<?= $this->section("content") ?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="text-center">Agent info</h1>
            </div>
        </div>
    </div>
</section>

<section class="content" id="agent-info-box">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <form class="card card-default" @submit="submit">
                    <div class="card-header d-flex align-items-baseline"></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label">Logo</label>
                            <div class="d-flex justify-content-center mb-3">
                                <img :src="form.logo_upload || form.logo" style="max-width: 320px; max-height: 100px;" />
                            </div>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" id="logo" class="custom-file-input" placeholder="Logo" accept="image/png, image/jpeg" @change="onFileChange" :disabled="mode.active == mode.display">
                                    <label class="custom-file-label" for="logo">Choose file</label>
                                </div>
                                <span v-if="form.logo_upload" class="input-group-append">
                                    <button type="button" class="btn btn-warning btn-flat" data-target="logo" @click="removeImage" :disabled="mode.active == mode.display">Remove</button>
                                </span>
                            </div>
                            <hr />
                        </div>
                        <div class="form-group">
                            <label class="form-label">Site title</label>
                            <input type="text" class="form-control" placeholder="Site title" v-model="form.name" :disabled="mode.active == mode.display" />
                        </div>
                        <div class="form-group">
                            <label class="form-label">Site description</label>
                            <input type="text" class="form-control" placeholder="Site description" v-model="form.description" :disabled="mode.active == mode.display" />
                        </div>
                        <div class="form-group">
                            <label class="form-label">Site domain</label>
                            <input type="url" class="form-control" placeholder="https://xxxx.xxx" v-model="form.url" :disabled="mode.active == mode.display" />
                        </div>
                        <div class="form-group">
                            <label class="form-label">Line id</label>
                            <input type="text" class="form-control" placeholder="Line id" v-model="form.line_id" :disabled="mode.active == mode.display" />
                        </div>
                        <div class="form-group">
                            <label class="form-label">Line link</label>
                            <input type="text" class="form-control" placeholder="Line link" v-model="form.line_link" :disabled="mode.active == mode.display" />
                        </div>
                        <div class="form-group">
                            <label class="form-label">Meta Tag</label>
                            <textarea class="form-control" placeholder="Meta Tag from Facebook." rows="10" v-model="form.meta_tag" :disabled="mode.active == mode.display"></textarea>
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
                    logo: ``,
                    logo_upload: ``,
                    url: ``,
                    name: ``,
                    description: ``,
                    line_id: ``,
                    line_link: ``,
                    meta_tag: ``,
                },
            }
        },
        methods: {
            async info(e) {
                e?.preventDefault()
                this.loading = true
                let { status, message, data } = await post(`agent/info`)
                this.loading = false
                if (!status) return flashAlert.warning(message)

                let { logo, url, name, description, line_id, line_link, meta_tag } = data
                this.form = { logo, url, name, description, line_id, line_link, meta_tag }

                this.mode.active = this.mode.display
                this.removeImage(e)
            },
            async submit(e) {
                e?.preventDefault()
                // return console.log(this.form)
                this.loading = true
                let { status, message, data } = await post(`agent/info/update`, this.form)
                this.loading = false
                if (!status) return flashAlert.warning(message)
                return showAlert.success(message, () => {
                    this.info(e)
                })
            },
            onFileChange(e) {
                e?.preventDefault()
                let files = e.target.files || e.dataTransfer.files
                if (!files.length) return
                this.createImage(files[0], e.target.id)
            },
            createImage(file, target) {
                let image = new Image()
                let reader = new FileReader()
                let vm = this

                reader.onload = (e) => {
                    vm.form[`${target}_upload`] = e.target.result
                }
                reader.readAsDataURL(file)
            },
            removeImage: function(e) {
                e?.preventDefault()
                let target = e?.target.dataset.target
                this.form[`${target}_upload`] = ``
                $(`#${target}`).val(``)
            },
        },
        mounted() {
            this.info()
        }
    }).mount('#agent-info-box')
</script>

<?= $this->endSection() ?>