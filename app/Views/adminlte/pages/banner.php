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
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <input type="search" class="form-control" placeholder="Search..." v-model="filter" @input="filter_banner">
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="banner-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        <button class="btn btn-xs btn-success" @click="add" :disabled="loading">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Detail</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(data, index) in table.filtered">
                                    <td>
                                        <button class="btn btn-xs btn-primary" :data-id="data.id" @click="info(data)" :disabled="loading">
                                            <i class="fa fa-pen" :data-id="data.id"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <img :src="data.image" :style="{ maxWidth: `100px`, maxHeight: `32px`,}">
                                    </td>
                                    <td>{{ data.name }}</td>
                                    <td>{{ data.detail }}</td>
                                    <td>
                                        <div class="btn-group" v-if="+data.status">
                                            <button type="button" class="btn btn-xs btn-success">Active</button>
                                            <button type="button" class="btn btn-xs btn-success" @click="remove(data)">
                                                <i class="fa fa-redo-alt"></i>
                                            </button>
                                        </div>
                                        <div class="btn-group" v-else>
                                            <button type="button" class="btn btn-xs btn-danger">Inactive</button>
                                            <button type="button" class="btn btn-xs btn-danger" @click="reuse(data)">
                                                <i class="fa fa-redo-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="banner-modal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" @submit="submit">
                <div class="modal-header">
                    <h4 class="modal-title">Banner info</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" v-if="modal.form">
                    <div class="form-group">
                        <label class="form-label">Image</label>
                        <div class="d-flex justify-content-center mb-3">
                            <img :src="modal.form.image_upload || modal.form.image" style="max-width: 200px; max-height: 64px;" />
                        </div>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" id="image" class="custom-file-input" placeholder="Image" accept="image/png, image/jpeg" @change="onFileChange">
                                <label class="custom-file-label" for="image">Choose file</label>
                            </div>
                            <span class="input-group-append">
                                <button type="button" class="btn btn-warning btn-flat" data-target="image" @click="removeImage">Remove</button>
                            </span>
                        </div>
                        <hr />
                    </div>
                    <div class="form-group">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" placeholder="Name" v-model="modal.form.name" />
                    </div>
                    <div class="form-group">
                        <label class="form-label">Detail</label>
                        <input type="text" class="form-control" placeholder="Detail" v-model="modal.form.detail" />
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="submit" class="btn btn-primary" :disabled="loading">Save changes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal" :disabled="loading">Close</button>
                </div>
            </form>

        </div>

    </div>
</section>


<script>
    Vue.createApp({
        data() {
            return {
                loading: false,
                filter: ``,
                modal: {
                    target: null,
                    form: null,
                    darft: { id: ``, name: ``, detail: ``, image: ``, image_upload: `` }
                },
                table: {
                    filtered: [],
                    data: [],
                },
            }
        },
        methods: {
            async list() {
                this.loading = true
                let { status, message, data } = await post(`banner/list`)
                this.loading = false
                if (!status) return showAlert.warning(message)
                this.table.data = data
                this.filter_banner()
            },
            filter_banner() {
                let _filter = this.filter
                if (!_filter) return this.table.filtered = this.table.data
                this.table.filtered = this.table.data?.filter((item) => {
                    return item.name?.indexOf(_filter) > -1 || item.detail?.indexOf(_filter) > -1
                }) || []
            },
            add(e) {
                e?.preventDefault()
                this.modal.form = { ...this.modal.darft }
                this.modal.target.modal(`show`)
            },
            async info(banner) {
                if (!banner) return
                this.loading = true
                let { status, message, data } = await post(`banner/info`, { id: banner.id })
                this.loading = false
                if (!status) return showAlert.warning(message)
                let { id, name, detail, image } = data
                this.modal.form = { id, name, detail, image, image_upload: `` }
                this.modal.target.modal(`show`)
            },
            async submit(e) {
                e?.preventDefault()
                this.loading = true
                let endpoint = this.modal.form.id ? `banner/info/update` : `banner/add`
                let { status, message, data } = await post(endpoint, this.modal.form)
                this.loading = false
                if (!status) return showAlert.warning(message)
                let { id, name, detail, image } = data
                this.modal.form = { id, name, detail, image, image_upload: `` }
                let vm = this
                return showAlert.success(message, function() {
                    vm.list()
                    vm.modal.target.modal(`hide`)
                })
            },
            remove(banner) {
                let vm = this
                return showConfirm(`Confirm remove ?`, function(_f) {
                    if (!_f.isConfirmed) return
                    return vm.status(`remove`, banner)
                })
            },
            reuse(banner) {
                let vm = this
                return showConfirm(`Confirm reuse ?`, function(_f) {
                    if (!_f.isConfirmed) return
                    return vm.status(`reuse`, banner)
                })
            },
            async status(type, banner) {
                this.loading = true
                let { status, message } = await post(`banner/${type}`, { id: banner.id })
                this.loading = false
                if (!status) return showAlert.warning(message)
                let vm = this
                return showAlert.success(message, function() {
                    vm.list()
                }, 1000)
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
                    vm.modal.form[`${target}_upload`] = e.target.result
                }
                reader.readAsDataURL(file)
            },
            removeImage: function(e) {
                e?.preventDefault()
                let target = e?.target.dataset.target
                this.modal.form[`${target}_upload`] = ``
                $(`#${target}`).val(``)
            },
        },
        async mounted() {
            this.modal.target = $(`#banner-modal`)
            await this.list()
        }
    }).mount('#banner-box')
</script>

<?= $this->endSection() ?>