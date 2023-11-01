<?= $this->extend("adminlte/layouts/basic") ?>

<?= $this->section("content") ?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="text-center">Agents</h1>
            </div>
        </div>
    </div>
</section>

<section class="content" id="agent-box">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex flex-row justify-content-between">
                            <input type="search" class="form-control w-50" placeholder="Search..." v-model="filter" @input="filter_agent">
                            <button class="btn btn-success" @click="add" :disabled="loading">
                                <i class="fa fa-plus"></i> Add
                            </button>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="agent-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        <button class="btn btn-xs btn-success" @click="add" :disabled="loading">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </th>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Key</th>
                                    <th>Secret</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(data, index) in table.filtered">
                                    <td>
                                        <button class="btn btn-xs btn-primary" @click="info(data)" :disabled="loading">
                                            <i class="fa fa-pen"></i>
                                        </button>
                                    </td>
                                    <td>{{ data.name }}</td>
                                    <td>{{ data.code }}</td>
                                    <td>{{ data.key }}</td>
                                    <td>{{ data.secret }}</td>
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
                                        <!-- <button type="button" class="btn btn-xs btn-danger ml-2"><i class="fa fa-trash-alt"></i></button> -->
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
    <div class="modal fade" id="agent-modal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" @submit="submit">
                <div class="modal-header">
                    <h4 class="modal-title">Agent info</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" v-if="modal.form">
                    <div class="form-group">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" placeholder="Name" v-model="modal.form.name" />
                    </div>
                    <div class="form-group">
                        <label class="form-label">Key</label>
                        <input type="text" class="form-control" placeholder="Key" v-model="modal.form.key" />
                    </div>
                    <div class="form-group">
                        <label class="form-label">Secret</label>
                        <input type="text" class="form-control" placeholder="Secret" v-model="modal.form.secret" />
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
                    darft: { key: ``, secret: ``, name: ``, }
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
                let { status, message, data } = await post(`agent/list`)
                this.loading = false
                if (!status) return showAlert.warning(message)
                this.table.data = data
                this.filter_agent()
            },
            filter_agent() {
                let _filter = this.filter
                if (!_filter) return this.table.filtered = this.table.data
                this.table.filtered = this.table.data?.filter((item) => {
                    return item.username?.indexOf(_filter) > -1 || item.name?.indexOf(_filter) > -1 || item.tel?.indexOf(_filter) > -1
                }) || []
            },
            info(agent) {
                if (!agent) return
                location.href = `<?= site_url() ?>/agent/${agent.code}/${agent.key}/${agent.secret}`
            },
            add(e) {
                e?.preventDefault()
                this.modal.form = { ...this.modal.darft }
                this.modal.target.modal(`show`)
            },
            async submit(e) {
                e?.preventDefault()
                this.loading = true
                let { status, message, data } = await post(`agent/add`, this.modal.form)
                this.loading = false
                if (!status) return showAlert.warning(message)
                let vm = this
                return showAlert.success(message, function() {
                    if (data) return vm.info(data)
                    vm.list()
                    vm.modal.target.modal(`hide`)
                })
            },
            status_inactive(agent) {
                let vm = this
                return showConfirm(`Confirm Inactive ?`, function(_f) {
                    if (!_f.isConfirmed) return
                    return vm.status(`inactive`, agent)
                })
            },
            status_active(agent) {
                let vm = this
                return showConfirm(`Confirm Active ?`, function(_f) {
                    if (!_f.isConfirmed) return
                    return vm.status(`active`, agent)
                })
            },
            async status(type, agent) {
                this.loading = true
                let { id, code, key, secret } = agent
                let { status, message } = await post(`agent/${type}`, { id, code, key, secret })
                this.loading = false
                if (!status) return showAlert.warning(message)
                let vm = this
                return showAlert.success(message, function() {
                    vm.list()
                }, 1000)
            },
        },
        async mounted() {
            this.modal.target = $(`#agent-modal`)
            await this.list()
        }
    }).mount('#agent-box')
</script>

<?= $this->endSection() ?>