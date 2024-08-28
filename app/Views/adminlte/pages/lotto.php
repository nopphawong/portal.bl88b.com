<?= $this->extend("adminlte/layouts/basic") ?>

<?= $this->section("content") ?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="text-center">Lotto</h1>
            </div>
        </div>
    </div>
</section>

<section class="content" id="lotto-box">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body table-responsive">
                        <p-datatable class="table table-striped" :value="table.data" :size="`small`" paginator :rows="10">
                            <p-column field="id">
                                <template #header>
                                    <button class="btn btn-success btn-xs" @click="add" :disabled="loading">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </template>
                                <template #body="slotProps">
                                    <button class="btn btn-primary btn-xs" @click="edit(slotProps.data.id)" :disabled="loading">
                                        <i class="fa fa-pen"></i>
                                    </button>
                                </template>
                            </p-column>
                            <p-column field="period" header="งวด">
                                <template #body="slotProps">
                                    {{ web_datetime(slotProps.data.period) }}
                                </template>
                            </p-column>
                            <p-column field="name" header="ชื่อแผง"></p-column>
                            <p-column field="type_name" header="ประเภท"></p-column>
                            <p-column field="start" header="วันที่เริ่มขาย">
                                <template #body="slotProps">
                                    {{ web_datetime_hm(slotProps.data.start) }}
                                </template>
                            </p-column>
                            <p-column field="expire" header="วันที่ปิดแผง">
                                <template #body="slotProps">
                                    {{ web_datetime_hm(slotProps.data.expire) }}
                                </template>
                            </p-column>
                            <p-column field="sold" header="การขาย" class="text-center">
                                <template #body="slotProps">
                                    {{ `${slotProps.data.sold}/${slotProps.data.stock}` }}
                                </template>
                            </p-column>
                            <p-column field="id" header="ตรวจผล" class="text-center">
                                <template #body="slotProps">
                                    <button class="btn btn-primary btn-xs" @click="bingo(slotProps.data.id)" :disabled="loading">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </template>
                            </p-column>
                            <p-column field="bingo" header="เลขที่ออก" class="text-center">
                                <template #body="slotProps">
                                    <div v-if="!slotProps.data.bingo" class="text-center bg-warning">รอผล</div>
                                    <div v-else class="text-center bg-success fs-6">{{ slotProps.data.bingo }}</div>
                                </template>
                            </p-column>
                            <p-column field="winner" header="ผู้ชนะ" class="text-center">
                                <template #body="slotProps">
                                    <div v-if="!slotProps.data.bingo" class="text-center bg-warning">รอผล</div>
                                    <div v-else-if="!slotProps.data.winner" class="text-center bg-secondary">ไม่มีผู้ถูกรางวัล</div>
                                    <div v-else class="text-center bg-success fs-6">{{ slotProps.data.winner }}</div>
                                </template>
                            </p-column>
                            <p-column field="status" header="สถานะ" class="text-center">
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
                            <p-column header="ลบ" class="text-center">
                                <template #body="slotProps">
                                    <button class="btn btn-xs btn-danger" @click="remove(slotProps.data.id)" :disabled="loading">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </template>
                            </p-column>
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
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->include("adminlte/modals/lotto_info") ?>
<?= $this->include("adminlte/modals/lotto_bingo") ?>

<script>
    const lottoBox = Vue.createApp({
        data() {
            return {
                loading: false,
                filter: ``,
                excel: null,
                modal: {
                    target: null,
                    form: {},
                    darft: { type: ``, name: ``, period: ``, start: ``, expire: ``, reward: ``, price: ``, bingo: ``, bingo: `` }
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
                let { status, message, data } = await post(`lotto/list`)
                this.loading = false
                if (!status) return flashAlert.warning(message)
                this.table.data = data
            },
            async remove(id) {
                return showConfirm(`Confirm Delete !`, async (_f) => {
                    if (!_f.isConfirmed) return
                    this.loading = true
                    let { status, message, data } = await post(`lotto/remove/${id}`)
                    this.loading = false
                    if (!status) return flashAlert.warning(message)
                    await this.list()
                    return flashAlert.success(message)
                })
            },
            async toggle(id, actived) {
                return showConfirm(`Confirm !`, async (_f) => {
                    if (!_f.isConfirmed) return
                    this.loading = true
                    let { status, message, data } = await post(`lotto/active/${id}/${actived == `1` ? `0` : `1`}`)
                    this.loading = false
                    if (!status) return flashAlert.warning(message)
                    await this.list()
                    return flashAlert.success(message)
                })
            },
            async edit(id) {
                this.loading = true
                await lottoModal.edit(id)
                this.loading = false
            },
            add() {
                lottoModal.add()
            },
            web_datetime(date) {
                return date_format(date, DATE_FORMAT.DB_DATETIME, DATE_FORMAT.WEB_DATE)
            },
            web_datetime_hm(date) {
                return date_format(date, DATE_FORMAT.DB_DATETIME, DATE_FORMAT.WEB_DATETIME_HM)
            },
            async bingo(id) {
                this.loading = true
                await bingoModal.edit(id)
                this.loading = false
            },
        },
        async mounted() {
            this.modal.form = { ...this.modal.darft }
            await this.list()
            lottoModal.onAfterSave = async () => {
                await this.list()
                lottoModal.close()
            }
            bingoModal.onAfterSave = async () => {
                await this.list()
            }
        }
    })
    lottoBox.use(PrimeVue.Config, {
        theme: { preset: PrimeVue.Themes.Aura }
    })
    lottoBox.component(`p-datatable`, PrimeVue.DataTable)
    lottoBox.component(`p-column`, PrimeVue.Column)
    lottoBox.mount('#lotto-box')
</script>

<?= $this->endSection() ?>