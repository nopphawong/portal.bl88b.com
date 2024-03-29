<?= $this->extend("adminlte/layouts/basic") ?>

<?= $this->section("content") ?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="text-center">Web Users <?= session()->agent && session()->agent->name ? "(" . session()->agent->name . ")" : "" ?></h1>
            </div>
        </div>
    </div>
</section>

<section class="content" id="webuser-box">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form class="card" @submit="submit">
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" placeholder="Username" id="username" v-model="modal.form.username" />
                        </div>
                        <div class="form-group">
                            <label class="form-label">Password</label>
                            <input type="text" class="form-control" placeholder="Password" id="password" v-model="modal.form.password" />
                        </div>
                        <div class="form-group">
                            <label class="form-label">Agent</label>
                            <input type="text" class="form-control" placeholder="Agent" id="agent" v-model="modal.form.agent" />
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary w-100" :disabled="loading">Add</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12">
                                <small style="float: right;">Example: <?= anchor(base_url("files/webuser.xlsx"), "WebUser.xlsx") ?></small><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <input type="search" class="form-control" placeholder="Search..." v-model="filter" @input="filter_webuser">
                            </div>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <div v-if="excel" class="input-group-prepend">
                                        <button type="button" class="btn btn-warning btn-flat" data-target="excel" :disabled="loading" @click="removeFile">Remove</button>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" id="excel" class="custom-file-input" placeholder=".xlsx" accept=".xlsx, .xls, .csv" @change="onFileChange">
                                        <label class="custom-file-label" for="excel">{{ excel?.name || `Choose file` }}</label>
                                    </div>
                                    <span v-if="excel" class="input-group-append">
                                        <button type="button" class="btn btn-primary btn-flat" data-target="excel" :disabled="loading" @click="upload">Upload</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="webuser-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Web Username</th>
                                    <th>Web Password</th>
                                    <th>Web Agent</th>
                                    <!-- <th>Owner Agent</th> -->
                                    <th>Use Date</th>
                                    <th>Use Tel</th>
                                    <th>Status</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(data, index) in table.filtered">
                                    <td>{{data.web_username}}</td>
                                    <td>{{data.web_password}}</td>
                                    <td>{{data.web_agent}}</td>
                                    <!-- <td>{{data.agent_name}}</td> -->
                                    <td>{{data.date_use}}</td>
                                    <td>{{data.tel}}</td>
                                    <td>
                                        <div class="btn-group" v-if="+data.status">
                                            <button type="button" class="btn btn-xs btn-success">Active</button>
                                            <button type="button" class="btn btn-xs btn-success" :disabled="loading || data.date_use" @click="toggle(data.web_username, data.status)">
                                                <i class="fa fa-redo-alt"></i>
                                            </button>
                                        </div>
                                        <div class="btn-group" v-else>
                                            <button type="button" class="btn btn-xs btn-warning">Inactive</button>
                                            <button type="button" class="btn btn-xs btn-warning" :disabled="loading || data.date_use" @click="toggle(data.web_username, data.status)">
                                                <i class="fa fa-redo-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td>
                                        <button class="btn btn-xs btn-danger" @click="remove(data.web_username)" :disabled="loading || data.date_use">
                                            <i class="fa fa-trash"></i>
                                        </button>
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
</section>

<script>
    Vue.createApp({
        data() {
            return {
                loading: false,
                filter: ``,
                excel: null,
                modal: {
                    target: null,
                    form: {},
                    darft: { username: ``, password: ``, agent: `` }
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
                let { status, message, data } = await post(`webuser/list`)
                this.loading = false
                if (!status) return flashAlert.warning(message)
                this.table.data = data
                this.filter_webuser()
            },
            filter_webuser() {
                let _filter = this.filter
                if (!_filter) return this.table.filtered = this.table.data
                this.table.filtered = this.table.data?.filter((item) => {
                    return item.username?.indexOf(_filter) > -1 || item.tel?.indexOf(_filter) > -1
                }) || []
            },
            async submit(e) {
                e?.preventDefault()

                if (!this.modal.form.username) return $(`#username`)[0].focus()
                if (!this.modal.form.password) return $(`#password`)[0].focus()
                if (!this.modal.form.agent) return $(`#agent`)[0].focus()

                this.loading = true
                let { status, message, data } = await post(`webuser/add`, { ...this.modal.form })
                this.loading = false
                this.modal.form = { ...this.modal.darft }
                $(`#username`)[0].focus()
                if (!status) return flashAlert.warning(message)
                await this.list()
            },
            async upload(e) {
                e?.preventDefault()
                this.loading = true
                let body = new FormData()
                body.append(`excel`, this.excel)
                let { status, message, data } = await multipath(`webuser/import`, body)
                this.loading = false
                if (!status) return flashAlert.warning(message)
                flashAlert.success(message)
                await this.list()
                this.removeFile(e)
            },
            async remove(username) {
                return showConfirm(`Confirm !`, async (_f) => {
                    if (!_f.isConfirmed) return
                    this.loading = true
                    let { status, message, data } = await post(`webuser/remove/${username}`)
                    this.loading = false
                    if (!status) return flashAlert.warning(message)
                    await this.list()
                    return flashAlert.success(message)
                })
            },
            async toggle(username, actived) {
                return showConfirm(`Confirm !`, async (_f) => {
                    if (!_f.isConfirmed) return
                    this.loading = true
                    let { status, message, data } = await post(`webuser/toggle/${username}/${actived == 1 ? 0 : 1}`)
                    this.loading = false
                    if (!status) return flashAlert.warning(message)
                    await this.list()
                    return flashAlert.success(message)
                })
            },
            onFileChange(e) {
                e?.preventDefault()
                let files = e.target.files || e.dataTransfer.files
                if (!files.length) return
                this.excel = files[0]
            },
            removeFile: function(e) {
                e?.preventDefault()
                let target = e?.target.dataset.target
                this.excel = ``
                $(`#${target}`).val(``)
            },
        },
        async mounted() {
            this.modal.form = { ...this.modal.darft }
            await this.list()
        }
    }).mount('#webuser-box')
</script>

<?= $this->endSection() ?>