<?= $this->extend("adminlte/layouts/basic") ?>

<?= $this->section("content") ?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="text-center">Web Users</h1>
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
                            <input type="text" class="form-control" placeholder="Username" pattern="^[a-zA-Z0-9]{4,}" id="username" v-model="modal.form.username" />
                        </div>
                        <div class="form-group">
                            <label class="form-label">Password</label>
                            <input type="text" class="form-control" placeholder="Password" pattern="^[a-zA-Z0-9]{4,}" id="password" v-model="modal.form.password" />
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary w-100">Add</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex flex-row justify-content-between">
                            <input type="search" class="form-control w-50" placeholder="Search..." v-model="filter" @input="filter_webuser">
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="webuser-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>Use Date</th>
                                    <th>Use by</th>
                                    <th>Use Tel</th>
                                    <th>Status</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(data, index) in table.filtered">
                                    <td>{{data.web_username}}</td>
                                    <td>{{data.web_password}}</td>
                                    <td>{{data.date_use}}</td>
                                    <td>{{data.agent_name}}</td>
                                    <td>{{data.tel}}</td>
                                    <td>
                                        <div class="btn-group" v-if="+data.status">
                                            <button type="button" class="btn btn-xs btn-success">Active</button>
                                            <button type="button" class="btn btn-xs btn-success" @click="toggle(data.web_username, data.status)">
                                                <i class="fa fa-redo-alt"></i>
                                            </button>
                                        </div>
                                        <div class="btn-group" v-else>
                                            <button type="button" class="btn btn-xs btn-warning">Inactive</button>
                                            <button type="button" class="btn btn-xs btn-warning" @click="toggle(data.web_username, data.status)">
                                                <i class="fa fa-redo-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td>
                                        <button class="btn btn-xs btn-danger" @click="remove(data.web_username)" :disabled="loading">
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
                modal: {
                    target: null,
                    form: {},
                    darft: { username: ``, password: ``, }
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


                this.loading = true
                let { status, message, data } = await post(`webuser/add`, { ...this.modal.form })
                this.loading = false
                this.modal.form = { ...this.modal.darft }
                $(`#username`)[0].focus()
                if (!status) return flashAlert.warning(message)
                await this.list()
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
            }
        },
        async mounted() {
            this.modal.form = { ...this.modal.darft }
            await this.list()
        }
    }).mount('#webuser-box')
</script>

<?= $this->endSection() ?>