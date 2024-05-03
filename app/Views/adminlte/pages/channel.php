<?= $this->extend("adminlte/layouts/basic") ?>

<?= $this->section("content") ?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="text-center">Channels</h1>
            </div>
        </div>
    </div>
</section>

<section class="content" id="channel-box">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex flex-row justify-content-between">
                            <input type="search" class="form-control w-50" placeholder="Search..." v-model="filter" @input="filter_channel">
                            <button class="btn btn-success" @click="add" :disabled="loading">
                                <i class="fa fa-plus"></i> Add
                            </button>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="channel-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        <button class="btn btn-xs btn-success" @click="add" :disabled="loading">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </th>
                                    <th>Ref</th>
                                    <th>Name</th>
                                    <th>Descript</th>
                                    <th>Link</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(data, index) in table.filtered">
                                    <td>
                                        <button class="btn btn-xs btn-primary" @click="info(data)" :disabled="loading">
                                            <i class="fa fa-pen"></i>
                                        </button>
                                    </td>
                                    <td>{{ data.ref }}</td>
                                    <td>{{ data.name }}</td>
                                    <td>{{ data.description }}</td>
                                    <td>
                                        <button class="btn btn-xs btn-warning" @click="copyToClipboard(data)">
                                            <i class="fa fa-copy"></i>
                                        </button>
                                        {{ data.link }}
                                    </td>
                                    <td>
                                        <div class="btn-group" v-if="+data.status">
                                            <button type="button" class="btn btn-xs btn-success">Active</button>
                                            <button type="button" class="btn btn-xs btn-success" @click="status_inactive(data)">
                                                <i class="fa fa-redo-alt"></i>
                                            </button>
                                        </div>
                                        <div class="btn-group" v-else>
                                            <button type="button" class="btn btn-xs btn-warning">Inactive</button>
                                            <button type="button" class="btn btn-xs btn-warning" @click="status_active(data)">
                                                <i class="fa fa-redo-alt"></i>
                                            </button>
                                        </div>
                                        <button type="button" class="btn btn-xs btn-danger ml-2" @click="record_delete(data)"><i class="fa fa-trash-alt"></i></button>
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
    <div class="modal fade" id="channel-modal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" @submit="submit">
                <div class="modal-header">
                    <h4 class="modal-title">Channel info</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" v-if="modal.form">
                    <div class="form-group">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" placeholder="Name." v-model="modal.form.name" />
                    </div>
                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <input type="text" class="form-control" placeholder="Description." v-model="modal.form.description" />
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="submit" class="btn btn-primary" :disabled="loading">Save</button>
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
                    darft: { id: ``, name: ``, description: ``, link: `` }
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
                let { status, message, data } = await post(`channel/list`)
                this.loading = false
                if (!status) return flashAlert.warning(message)
                this.table.data = data
                this.filter_channel()
            },
            filter_channel() {
                let _filter = this.filter
                if (!_filter) return this.table.filtered = this.table.data
                this.table.filtered = this.table.data?.filter((item) => {
                    return item.name?.indexOf(_filter) > -1 || item.description?.indexOf(_filter) > -1
                }) || []
            },
            add(e) {
                e?.preventDefault()
                this.modal.form = { ...this.modal.darft }
                this.modal.target.modal(`show`)
            },
            async info(channel) {
                if (!channel) return
                this.loading = true
                let { status, message, data } = await post(`channel/info`, { id: channel.id })
                this.loading = false
                if (!status) return flashAlert.warning(message)
                let { id, name, description, link } = data
                this.modal.form = { id, name, description, link }
                this.modal.target.modal(`show`)
            },
            async submit(e) {
                e?.preventDefault()
                this.loading = true
                let { status, message, data } = await post(`channel/save`, this.modal.form)
                this.loading = false
                if (!status) return flashAlert.warning(message)
                let { id, name, tel, username, password } = data
                this.modal.form = { id, name, tel, username, password }
                let vm = this
                return showAlert.success(message, function() {
                    vm.list()
                    vm.modal.target.modal(`hide`)
                })
            },
            status_inactive(channel) {
                let vm = this
                return showConfirm(`Confirm Inactive ?`, function(_f) {
                    if (!_f.isConfirmed) return
                    return vm.status(`active/0`, channel)
                })
            },
            status_active(channel) {
                let vm = this
                return showConfirm(`Confirm Active ?`, function(_f) {
                    if (!_f.isConfirmed) return
                    return vm.status(`active/1`, channel)
                })
            },
            record_delete(banner) {
                let vm = this
                return showConfirm(`Confirm Delete ?`, function(_f) {
                    if (!_f.isConfirmed) return
                    return vm.status(`delete`, banner)
                })
            },
            async status(type, channel) {
                this.loading = true
                let { status, message } = await post(`channel/${type}`, { id: channel.id })
                this.loading = false
                if (!status) return flashAlert.warning(message)
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
            copyToClipboard(channel) {
                flashAlert.success(`Copy: ${channel.link}`)
                return copyToClipboard(channel.link)
            },
        },
        async mounted() {
            this.modal.target = $(`#channel-modal`)
            await this.list()
        }
    }).mount('#channel-box')
</script>

<?= $this->endSection() ?>