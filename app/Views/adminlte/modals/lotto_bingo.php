<section id="bingo-modal-box">
    <div class="modal fade" id="bingo-modal" style="display: none;" aria-hidden="true" data-bs-backdrop="static" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">ข้อมูล Lotto</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit="submit">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">งวดที่</label>
                                    <p-datepicker class="form-control" v-model="form.data.period" date-format="dd/mm/yy" disabled />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">ประเภท</label>
                                    <p-select class="form-select" v-model="form.data.type" :options="options.types" option-label="name" option-value="code" disabled />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- <div class="col-3"></div> -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">เลขที่ออก</label>
                                    <div class="input-group">
                                        <p-text class="form-control" v-model="form.data.bingo"></p-text>
                                        <button class="btn btn-primary" :disabled="loading">ตรวจรางวัล</button>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-3"></div> -->
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-12">
                            <p-datatable class="table table-striped" :value="table.data" :size="`small`" paginator :rows="rows.perpage" :row-per-page-options="rows.list">
                                <p-column field="no" header="ผลรางวัล" class="text-center">
                                    <template #body="slotProps">
                                        <div v-if="slotProps.data.ended == `0`" class="text-center bg-warning">รอผล</div>
                                        <div v-else-if="slotProps.data.winner == `1`" class="text-center bg-success">ถูกรางวัล</div>
                                        <div v-else class="text-center bg-danger">ไม่ถูกรางวัล</div>
                                    </template>
                                </p-column>
                                <p-column field="no" header="หมายเลข" class="text-center"></p-column>
                                <p-column field="buyer" header="ผู้ซื้อ"></p-column>
                                <!-- <p-column field="status" header="สถานะ" class="text-center">
                                    <template #body="slotProps">
                                        <div class="btn-group" v-if="+slotProps.data.status">
                                            <button type="button" class="btn btn-xs btn-success">ใช้งาน</button>
                                            <button type="button" class="btn btn-xs btn-success" :disabled="loading" @click="toggle(slotProps.data.id, slotProps.data.status)">
                                                <i class="fa fa-redo-alt"></i>
                                            </button>
                                        </div>
                                        <div class="btn-group" v-else>
                                            <button type="button" class="btn btn-xs btn-warning">ยกเลิก</button>
                                            <button type="button" class="btn btn-xs btn-warning" :disabled="loading" @click="toggle(slotProps.data.id, slotProps.data.status)">
                                                <i class="fa fa-redo-alt"></i>
                                            </button>
                                        </div>
                                    </template>
                                </p-column>
                                <p-column header="ลบ" class="text-center">
                                    <template #body="slotProps">
                                        <button class="btn btn-xs btn-danger" @click="remove(slotProps.data.id)" :disabled="loading">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </template>
                                </p-column> -->
                                <template #paginatorstart>
                                    <select v-model="rows.perpage">
                                        <option v-for="value in rows.list" :value="value">{{ value }}</option>
                                    </select>
                                </template>
                                <template #paginatorend>
                                    Total: {{ table.data.length }}
                                </template>
                            </p-datatable>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" v-model="form.data.id">
                    <!-- <button type="submit" class="btn btn-primary" :disabled="loading">บันทึก</button> -->
                    <button type="button" class="btn btn-default" :disabled="loading" data-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    let bingoModal = Vue.createApp({
        data() {
            return {
                loading: false,
                target: null,
                form: {
                    data: {},
                    default: {
                        id: null,
                        type: null,
                        period: null,
                        bingo: null,
                    },
                },
                table: {
                    filtered: [],
                    data: [],
                },
                rows: {
                    perpage: 10,
                    list: [10, 20, 50, 100],
                },
                options: {
                    types: []
                },
                onAfterSave: null,
            }
        },
        methods: {
            open() {
                this.target.modal(`show`)
            },
            close() {
                this.target.modal(`hide`)
            },
            clear() {
                this.form.data = { ...this.form.default }
            },
            add() {
                this.display()
            },
            async edit(id) {
                this.loading = true
                let { status, message, data } = await post(`lotto/info`, { id })
                this.loading = false
                if (!status) return flashAlert.warning(message)
                let body = { ...data, period: new Date(data.period), }
                await this.list(id)
                return this.display(body)
            },
            async list(id) {
                this.loading = true
                let { status, message, data } = await post(`lotto/number/list`, { id })
                this.loading = false
                if (!status) return flashAlert.warning(message)
                this.table.data = data
            },
            display(data = {}) {
                this.form.data = { ...this.form.default, ...data }
                this.open()
            },
            async submit(e) {
                e?.preventDefault()
                return showConfirm(`ยืนยันผลรางวัล หมายเลข <div class="fs-3 text-success">${this.form.data.bingo}</div>`, async (_f) => {
                    if (!_f.isConfirmed) return
                    let body = { ...this.form.data }
                    this.loading = true
                    let { status, message, data } = await post(`lotto/bing/update`, { id: body.id, bingo: body.bingo })
                    this.loading = false
                    if (!status) return flashAlert.warning(message)
                    return flashAlert.success(message, async () => {
                        if (typeof this.onAfterSave == `function`) this.onAfterSave()
                        await this.edit(this.form.data.id)
                    })
                })
            },
            async load_type_list() {
                let { status, message, data } = await post(`lotto/type/list`)
                if (!status) return flashAlert.warning(message)
                this.options.types = data || []
            },
            async remove(id) {
                return showConfirm(`Confirm Delete !`, async (_f) => {
                    if (!_f.isConfirmed) return
                    this.loading = true
                    let { status, message, data } = await post(`lotto/number/remove/${id}`)
                    this.loading = false
                    if (!status) return flashAlert.warning(message)
                    await this.edit(this.form.data.id)
                    if (typeof this.onAfterSave == `function`) this.onAfterSave()
                    return flashAlert.success(message)
                })
            },
            async toggle(id, actived) {
                return showConfirm(`Confirm !`, async (_f) => {
                    if (!_f.isConfirmed) return
                    this.loading = true
                    let { status, message, data } = await post(`lotto/number/active/${id}/${actived == `1` ? `0` : `1`}`)
                    this.loading = false
                    if (!status) return flashAlert.warning(message)
                    await this.edit(this.form.data.id)
                    if (typeof this.onAfterSave == `function`) this.onAfterSave()
                    return flashAlert.success(message)
                })
            },
        },
        async mounted() {
            this.target = $(`#bingo-modal`)
            this.clear()
            await this.load_type_list()
        }
    })
    bingoModal.use(PrimeVue.Config, {
        theme: { preset: PrimeVue.Themes.Aura }
    })
    bingoModal.component(`p-datepicker`, PrimeVue.DatePicker)
    bingoModal.component(`p-select`, PrimeVue.Select)
    bingoModal.component(`p-text`, PrimeVue.InputText)
    bingoModal.component(`p-datatable`, PrimeVue.DataTable)
    bingoModal.component(`p-column`, PrimeVue.Column)
    bingoModal = bingoModal.mount(`#bingo-modal-box`)
</script>