<?= $this->extend("adminlte/layouts/basic") ?>

<?= $this->section("content") ?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="text-center">User Points</h1>
            </div>
        </div>
    </div>
</section>

<section class="content" id="user-box">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form class="card" @submit="submit">
                    <div class="card-body">
                        <div class="p-2"></div>
                        <div class="row">
                            <div class="col-6">
                                <p-float-label>
                                    <p-text class="form-control" placeholder="Tel" id="tel" v-model="modal.form.tel"></p-text>
                                    <label class="form-label" for="tel">เบอร์โทร</label>
                                </p-float-label>
                            </div>
                            <div class="col-3">
                                <p-float-label>
                                    <p-text class="form-control" placeholder="Points" id="point" v-model="modal.form.point"></p-text>
                                    <label class="form-label" for="point">แต้ม</label>
                                </p-float-label>
                            </div>
                            <div class="col-3">
                                <div class="btn-group w-100">
                                    <button type="submit" class="btn btn-primary w-100" :disabled="loading">Save</button>
                                    <button class="btn btn-default w-100" :disabled="loading" @click="clear">Clear</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header"></div>
                    <div class="card-body table-responsive">
                        <p-datatable class="table table-striped" :value="table.data" :size="`small`" paginator :rows="rows.perpage">
                            <p-column field="tel" header="เบอร์โทร"></p-column>
                            <p-column field="user" header="Web Username"></p-column>
                            <p-column field="point" header="แต้ม"></p-column>
                            <p-column field="status" header="Status">
                                <template #body="slotProps">
                                    <div class="btn-group" v-if="+slotProps.data.status">
                                        <button type="button" class="btn btn-xs btn-success">Active</button>
                                        <button type="button" class="btn btn-xs btn-success" :disabled="loading" @click="toggle(slotProps.data.id, slotProps.data.status)">
                                            <i class="fa fa-redo-alt"></i>
                                        </button>
                                    </div>
                                    <div class="btn-group" v-else>
                                        <button type="button" class="btn btn-xs btn-warning">Inactive</button>
                                        <button type="button" class="btn btn-xs btn-warning" :disabled="loading" @click="toggle(slotProps.data.id, slotProps.data.status)">
                                            <i class="fa fa-redo-alt"></i>
                                        </button>
                                    </div>
                                </template>
                            </p-column>
                            <p-column header="#">
                                <template #body="slotProps">
                                    <button class="btn btn-xs btn-danger" @click="remove(slotProps.data.id)" :disabled="loading">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </template>
                            </p-column>
                            <template #paginatorstart>
                                <select class="form-select" v-model="rows.perpage">
                                    <option v-for="value in rows.list" :value="value">{{ value }}</option>
                                    <!-- <option value="0">All</option> -->
                                </select>
                            </template>
                            <template #paginatorend>
                                Total: {{ table.filtered.length }}
                            </template>
                        </p-datatable>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    const userBox = Vue.createApp({
        data() {
            return {
                loading: false,
                filter: ``,
                excel: null,
                modal: {
                    target: null,
                    form: {},
                    darft: { tel: null, point: null }
                },
                table: {
                    filtered: [],
                    data: [],
                },
                rows: {
                    perpage: 10,
                    list: [10, 20, 50, 100],
                },
            }
        },
        methods: {
            async list() {
                this.loading = true
                let { status, message, data } = await post(`user/point/list`)
                this.loading = false
                if (!status) return flashAlert.warning(message)
                this.table.data = data
                // this.filter_user()
            },
            async submit(e) {
                e?.preventDefault()

                if (!this.modal.form.tel) return $(`#tel`)[0].focus()
                if (this.modal.form.point && isNaN(this.modal.form.point)) {
                    this.modal.form.point = null
                    return $(`#point`)[0].focus()
                }

                return showConfirm(`ยืนยันบันทึก <span class="fs-4 text-success">${this.modal.form.point || 0}</span> แต้ม<br/>
                ให้เบอร์โทร <span class="fs-4 text-primary">${this.modal.form.tel}</span> !`, async (_f) => {
                    if (!_f.isConfirmed) return
                    this.loading = true
                    let { status, message, data } = await post(`user/point/save`, { ...this.modal.form })
                    this.loading = false
                    if (!status) return flashAlert.warning(message, () => this.clear())
                    flashAlert.success(message)
                    await this.list()
                    this.clear()
                })
            },
            async remove(username) {
                return showConfirm(`Confirm Delete !`, async (_f) => {
                    if (!_f.isConfirmed) return
                    this.loading = true
                    let { status, message, data } = await post(`user/point/remove/${username}`)
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
                    let { status, message, data } = await post(`user/point/active/${username}/${actived == 1 ? 0 : 1}`)
                    this.loading = false
                    if (!status) return flashAlert.warning(message)
                    await this.list()
                    return flashAlert.success(message)
                })
            },
            clear(e) {
                e?.preventDefault()
                this.modal.form = { ...this.modal.darft }
                // setTimeout(() => $("#tel")[0].focus(), 100)
            },
        },
        async mounted() {
            this.clear()
            await this.list()
        }
    })
    userBox.use(PrimeVue.Config, {
        theme: { preset: PrimeVue.Themes.Aura }
    })
    userBox.component(`p-datatable`, PrimeVue.DataTable)
    userBox.component(`p-column`, PrimeVue.Column)
    userBox.component(`p-text`, PrimeVue.InputText)
    userBox.component(`p-number`, PrimeVue.InputNumber)
    userBox.component(`p-float-label`, PrimeVue.FloatLabel)
    userBox.mount('#user-box')
</script>

<?= $this->endSection() ?>