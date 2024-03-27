<?= $this->extend("adminlte/layouts/basic") ?>

<?= $this->section("content") ?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="text-center">Checkin info</h1>
            </div>
        </div>
    </div>
</section>

<section class="content" id="checkin-info-box">
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

<section class="content" id="progress-box">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex flex-row justify-content-end">
                            <!-- <input type="search" class="form-control w-50" placeholder="Search..." v-model="filter" @input="filter_progress"> -->
                            <!-- <button class="btn btn-success" @click="add()" :disabled="loading">
                                <i class="bx bx-plus-medical" ></i> Add
                            </button> -->
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="progress-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Edit</th>
                                    <th>Index</th>
                                    <th>Title</th>
                                    <th>Type</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(data, index) in table.filtered">
                                    <td>
                                        <button class="btn btn-xs btn-primary" @click="info(data)" :disabled="loading">
                                            <i class="fa fa-pen"></i>
                                        </button>
                                    </td>
                                    <td>{{ data.index }}</td>
                                    <td>{{ data.title }}</td>
                                    <td>{{ data.type }}</td>
                                    <td>{{ data.value }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <!-- <div class="d-flex justify-content-end">
                            <button class="btn btn-success" @click="shuffle()" :disabled="loading">
                                <i class="bx bx-sync"></i> Shuffle
                            </button>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="progress-modal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" @submit="submit">
                <div class="modal-header">
                    <h4 class="modal-title">Progress info</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" v-if="modal.form">
                    <div class="form-group">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" placeholder="Title" v-model="modal.form.title" />
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Type</label>
                                <input type="text" class="form-control" placeholder="Type" v-model="modal.form.type" disabled />
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Value</label>
                                <input type="text" class="form-control" placeholder="Value" v-model="modal.form.value" />
                            </div>
                        </div>
                    </div>
                </div>
                <!-- { id: ``, index: ``, title: ``, type: ``, value: ``, rate: ``, hex: ``, image: `` } -->
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
                let { status, message, data } = await post(`checkin/first`)
                this.loading = false
                if (!status) return flashAlert.warning(message)

                let { id, title, detail, deposit_rule } = data
                this.form = { id, title, detail, deposit_rule }

                this.mode.active = this.mode.display
            },
            async submit(e) {
                e?.preventDefault()
                this.loading = true
                let { status, message, data } = await post(`checkin/info/update`, this.form)
                this.loading = false
                if (!status) return flashAlert.warning(message)
                return showAlert.success(message, () => {
                    this.info(e)
                })
            },
        },
        async mounted() {
            await this.info()
            progressBox.checkin = this.form.id
            await progressBox.list()
        }
    }).mount('#checkin-info-box')

    const progressBox = Vue.createApp({
        data() {
            return {
                checkin: null,
                loading: false,
                filter: ``,
                modal: {
                    target: null,
                    form: null,
                    darft: { id: ``, index: ``, title: ``, type: ``, value: `` }
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
                let { status, message, data } = await post(`progress/list`, { checkin: this.checkin })
                this.loading = false
                if (!status) return flashAlert.warning(message)
                this.table.data = data
                this.filter_progress()
            },
            filter_progress() {
                let _filter = this.filter
                if (!_filter) return this.table.filtered = this.table.data
                this.table.filtered = this.table.data?.filter((item) => {
                    return item.title?.indexOf(_filter) > -1
                }) || []
            },
            add(e) {
                e?.preventDefault()
                this.modal.form = { ...this.modal.darft }
                this.modal.target.modal(`show`)
            },
            async info(progress) {
                if (!progress) return
                this.loading = true
                let { status, message, data } = await post(`progress/info`, { id: progress.id })
                this.loading = false
                if (!status) return flashAlert.warning(message)
                let { id, index, title, type, value } = data
                this.modal.form = { id, index, title, type, value }
                this.modal.target.modal(`show`)
            },
            async submit(e) {
                e?.preventDefault()
                this.loading = true
                let endpoint = this.modal.form.id ? `progress/info/update` : `progress/add`
                let { status, message, data } = await post(endpoint, this.modal.form)
                this.loading = false
                if (!status) return flashAlert.warning(message)
                let { id, index, title, type, value } = data
                this.modal.form = { id, index, title, type, value }
                let vm = this
                return showAlert.success(message, function() {
                    vm.list()
                    vm.modal.target.modal(`hide`)
                })
            },
        },
        async mounted() {
            this.modal.target = $(`#progress-modal`)
        }
    }).mount('#progress-box')
</script>

<?= $this->endSection() ?>