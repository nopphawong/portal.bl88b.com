<section id="lotto-modal-box">
    <div class="modal fade" id="lotto-modal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" @submit="submit">
                <div class="modal-header">
                    <h4 class="modal-title">ข้อมูล Lotto</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">งวดที่</label>
                                <p-datepicker class="form-control" v-model="form.period" date-format="dd/mm/yy" @update:model-value="onPeriodChange" />
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">ประเภท</label>
                                <p-select class="form-select" v-model="form.type" :options="options.types" option-label="name" option-value="code" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">ชื่อแผง</label>
                                <input type="text" class="form-control" v-model="form.name" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="form-group">
                                <label class="form-label">วันที่เริ่มขาย</label>
                                <p-datepicker class="form-control" v-model="form.start_date" date-format="dd/mm/yy" />
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label">เวลา</label>
                                <p-datepicker class="form-control" v-model="form.start_time" time-only />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="form-group">
                                <label class="form-label">วันที่ปิดแผง</label>
                                <p-datepicker class="form-control" v-model="form.expire_date" date-format="dd/mm/yy" />
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label">เวลา</label>
                                <p-datepicker class="form-control" v-model="form.expire_time" time-only />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" v-model="form.id">
                    <button type="submit" class="btn btn-primary" :disabled="loading">บันทึก</button>
                    <button type="button" class="btn btn-default" :disabled="loading" data-dismiss="modal">ปิด</button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    let lottoModal = Vue.createApp({
        data() {
            return {
                loading: false,
                target: null,
                form: {},
                form_default: {
                    id: null,
                    type: null,
                    name: null,
                    period: null,
                    start_date: null,
                    start_time: new Date(`2024-01-01 00:00:00`),
                    expire_date: null,
                    expire_time: new Date(`2024-01-01 12:00:00`),
                    reward: 50,
                    price: 1,
                    bingo: null,
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
                this.form = { ...this.form_default }
            },
            add() {
                this.display()
            },
            async edit(id) {
                this.loading = true
                let { status, message, data } = await post(`lotto/info`, { id })
                this.loading = false
                if (!status) return flashAlert.warning(message)
                let body = {
                    ...data,
                    period: new Date(data.period),
                    start_date: new Date(data.start),
                    start_time: new Date(data.start),
                    expire_date: new Date(data.expire),
                    expire_time: new Date(data.expire),
                }
                return this.display(body)
            },
            display(data = {}) {
                this.form = { ...this.form_default, ...data }
                this.open()
            },
            onPeriodChange(value) {
                this.form.expire_date = value
            },
            async submit(e) {
                e?.preventDefault()

                if (!this.form.period) return flashAlert.warning(`งวด ไม่ถูกต้อง !`)
                if (!this.form.type) return flashAlert.warning(`ประเภท ไม่ถูกต้อง !`)
                if (!this.form.name) return flashAlert.warning(`ต้องระบุ ชื่อแผง !`)
                if (!this.form.start_date) return flashAlert.warning(`วันที่เริ่มขาย ไม่ถูกต้อง !`)
                if (!this.form.start_time) return flashAlert.warning(`วันที่เริ่มขาย ไม่ถูกต้อง !`)
                if (!this.form.expire_date) return flashAlert.warning(`วันที่ปิดแผง ไม่ถูกต้อง !`)
                if (!this.form.expire_time) return flashAlert.warning(`วันที่ปิดแผง ไม่ถูกต้อง !`)

                let period = `${this.form.period.getFullYear()}-${this.form.period.getMonth()+1}-${this.form.period.getDate()}`
                // delete this.form.period

                let start = `${this.form.start_date.getFullYear()}-${this.form.start_date.getMonth()+1}-${this.form.start_date.getDate()} ${this.form.start_time.getHours()}:${this.form.start_time.getMinutes()}`
                if (isNaN((new Date(start)).getTime())) return flashAlert.warning(`วันที่เริ่มขาย ไม่ถูกต้อง !`)
                // delete this.form.start_date
                // delete this.form.start_time

                let expire = `${this.form.expire_date.getFullYear()}-${this.form.expire_date.getMonth()+1}-${this.form.expire_date.getDate()} ${this.form.expire_time.getHours()}:${this.form.expire_time.getMinutes()}`
                if (isNaN((new Date(expire)).getTime())) return flashAlert.warning(`วันที่ปิดแผง ไม่ถูกต้อง !`)
                // delete this.form.expire_date
                // delete this.form.expire_time

                let body = { ...this.form, start, expire, period }
                this.loading = true
                let { status, message, data } = await post(`lotto/save`, body)
                this.loading = false
                if (!status) return flashAlert.warning(message)
                return flashAlert.success(message, () => {
                    if (typeof this.onAfterSave == `function`) this.onAfterSave()
                })
            },
            async load_type_list() {
                let { status, message, data } = await post(`lotto/type/list`)
                if (!status) return flashAlert.warning(message)
                this.options.types = data || []
            },
        },
        async mounted() {
            this.target = $(`#lotto-modal`)
            this.form = { ...this.form_default }
            await this.load_type_list()
        }
    })
    lottoModal.use(PrimeVue.Config, {
        theme: { preset: PrimeVue.Themes.Aura }
    })
    lottoModal.component(`p-datepicker`, PrimeVue.DatePicker)
    lottoModal.component(`p-select`, PrimeVue.Select)
    lottoModal = lottoModal.mount(`#lotto-modal-box`)
</script>