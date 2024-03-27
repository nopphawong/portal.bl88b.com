<?= $this->extend("adminlte/layouts/basic") ?>

<?= $this->section("content") ?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="text-center">Wheel info</h1>
            </div>
        </div>
    </div>
</section>

<section class="content" id="wheel-info-box">
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
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">Background</label>
                                    <div class="d-flex justify-content-center mb-3">
                                        <img :src="form.new_background_image || form.background_image" style="max-width: 320px; max-height: 100px;" />
                                    </div>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" id="background_image" class="custom-file-input" placeholder="Background" accept="image/png, image/jpeg" @change="onFileChange" :disabled="mode.active == mode.display">
                                            <label class="custom-file-label" for="background_image">Choose file</label>
                                        </div>
                                        <span v-if="form.new_background_image" class="input-group-append">
                                            <button type="button" class="btn btn-warning btn-flat" data-target="background_image" @click="removeImage" :disabled="mode.active == mode.display">Remove</button>
                                        </span>
                                    </div>
                                    <hr />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">Arrow</label>
                                    <div class="d-flex justify-content-center mb-3">
                                        <img :src="form.new_arrow_image || form.arrow_image" style="max-width: 320px; max-height: 100px;" />
                                    </div>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" id="arrow_image" class="custom-file-input" placeholder="Arrow" accept="image/png, image/jpeg" @change="onFileChange" :disabled="mode.active == mode.display">
                                            <label class="custom-file-label" for="arrow_image">Choose file</label>
                                        </div>
                                        <span v-if="form.new_arrow_image" class="input-group-append">
                                            <button type="button" class="btn btn-warning btn-flat" data-target="arrow_image" @click="removeImage" :disabled="mode.active == mode.display">Remove</button>
                                        </span>
                                    </div>
                                    <hr />
                                </div>
                            </div>
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

<section class="content" id="segment-box">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex flex-row justify-content-end">
                            <!-- <input type="search" class="form-control w-50" placeholder="Search..." v-model="filter" @input="filter_segment"> -->
                            <!-- <button class="btn btn-success" @click="add()" :disabled="loading">
                                <i class="bx bx-plus-medical" ></i> Add
                            </button> -->
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="segment-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <!-- <th>Edit</th> -->
                                    <th>Title</th>
                                    <th>Type</th>
                                    <th>Value</th>
                                    <th>Rate</th>
                                    <th>Color</th>
                                    <th>Image</th>
                                </tr>
                            </thead>
                            <tbody v-if="mode.active == mode.display">
                                <tr v-for="(data, index) in table.filtered">
                                    <!-- <td>
                                        <button class="btn btn-xs btn-primary" @click="info(data)" :disabled="loading">
                                            <i class="fa fa-pen"></i>
                                        </button>
                                    </td> -->
                                    <td>{{ data.title }}</td>
                                    <td>{{ data.type }}</td>
                                    <td>{{ data.value }}</td>
                                    <td>{{ data.rate }}</td>
                                    <td>
                                        <div class="text-center" :style="{background:data.hex}">{{ data.hex }}</div>
                                    </td>
                                    <td>
                                        <img :src="data.new_image || data.image" style="max-height: 50px;">
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-if="mode.active == mode.edit">
                                <tr v-for="(data, index) in table.filtered">
                                    <!-- <td>
                                        <button class="btn btn-xs btn-primary" @click="info(data)" :disabled="loading">
                                            <i class="fa fa-pen"></i>
                                        </button>
                                    </td> -->
                                    <td>
                                        <input type="text" class="form-control" v-model="data.title">
                                    </td>
                                    <td>{{ data.type }}</td>
                                    <td>
                                        <input type="text" class="form-control" v-model="data.value">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" v-model="data.rate">
                                    </td>
                                    <td>
                                        <input type="color" class="form-control" v-model="data.hex">
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column align-items-center">
                                            <div v-if="data.new_image || data.image" class="d-flex justify-content-center" style="overflow: hidden; max-width: 75px; max-height: 75px;">
                                                <img class="w-100 h-100" :src="data.new_image || data.image">
                                            </div>
                                            <div class="btn-group w-100">
                                                <input type="file" class="form-control d-none" :id="`image${index}`" :data-row="index" @change="onFileChange" accept="image/png, image/jpeg">
                                                <label class="btn btn-default btn-sm m-0" :id="`preview${index}`" :data-row="index" :for="`image${index}`">
                                                    <i class="fas fa-upload"></i>
                                                </label>
                                                <button v-if="data.new_image" class="btn btn-warning btn-sm m-0" :data-row="index" @click="removeImage">
                                                    <i :data-row="index" class="fa fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-end gap-1">
                            <button v-if="mode.active == mode.display" type="button" class="btn btn-primary" @click="mode.active = mode.edit" :disabled="loading">
                                <i class="fa fa-wrench"></i> <span>Edit</span>
                            </button>
                            <button v-if="mode.active == mode.edit" type="button" class="btn btn-success" style="margin-right: .25rem;" @click="save" :disabled="loading">
                                <i class="fa fa-save"></i> <span>Save</span>
                            </button>
                            <button v-if="mode.active == mode.edit" type="button" class="btn btn-outline-secondary" @click="list" :disabled="loading">
                                <i class="fa fa-ban"></i> <span>Cancel</span>
                            </button>
                        </div>
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
    <div class="modal fade" id="segment-modal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" @submit="submit">
                <div class="modal-header">
                    <h4 class="modal-title">Segment info</h4>
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
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Rate</label>
                                <input type="text" class="form-control" placeholder="Rate" v-model="modal.form.rate" />
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Color</label>
                                <input type="color" class="form-control" placeholder="Color" v-model="modal.form.hex" />
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
                    background_image: ``,
                    new_background_image: ``,
                    arrow_image: ``,
                    new_arrow_image: ``,
                },
            }
        },
        methods: {
            async info(e) {
                e?.preventDefault()
                this.loading = true
                let { status, message, data } = await post(`wheel/first`)
                this.loading = false
                if (!status) return showAlert.warning(message)

                let { id, title, detail, deposit_rule, background_image, new_background_image, arrow_image, new_arrow_image } = data
                this.form = { id, title, detail, deposit_rule, background_image, new_background_image, arrow_image, new_arrow_image }

                this.mode.active = this.mode.display
            },
            async submit(e) {
                e?.preventDefault()
                this.loading = true
                let { status, message, data } = await post(`wheel/info/update`, this.form)
                this.loading = false
                if (!status) return showAlert.warning(message)
                return showAlert.success(message, () => {
                    this.info(e)
                })
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
                    vm.form[`new_${target}`] = e.target.result
                }
                reader.readAsDataURL(file)
            },
            removeImage: function(e) {
                e?.preventDefault()
                let target = e?.target.dataset.target
                this.form[`new_${target}`] = ``
                $(`#${target}`).val(``)
            },
        },
        async mounted() {
            await this.info()
            segmentBox.wheel = this.form.id
            await segmentBox.list()
        }
    }).mount('#wheel-info-box')

    const segmentBox = Vue.createApp({
        data() {
            return {
                wheel: null,
                loading: false,
                filter: ``,
                mode: {
                    active: ``,
                    edit: `edit`,
                    display: `display`,
                },
                modal: {
                    target: null,
                    form: null,
                    darft: { id: ``, index: ``, title: ``, type: ``, value: ``, rate: ``, hex: ``, image: `` }
                },
                table: {
                    filtered: [],
                    data: [],
                },
            }
        },
        methods: {
            async shuffle() {
                return showConfirm(`Confirm Shuffle !`, async (_f) => {
                    if (!_f.isConfirmed) return
                    this.loading = true
                    let { status, message, data } = await post(`segment/shuffle`, { wheel: this.wheel })
                    this.loading = false
                    if (!status) return showAlert.warning(message)
                    this.table.data = data
                    this.filter_segment()
                })
            },
            async list() {
                this.loading = true
                let { status, message, data } = await post(`segment/list`, { wheel: this.wheel })
                this.loading = false
                if (!status) return showAlert.warning(message)
                this.table.data = data
                this.filter_segment()
                this.mode.active = this.mode.display
            },
            filter_segment() {
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
            async info(segment) {
                if (!segment) return
                this.loading = true
                let { status, message, data } = await post(`segment/info`, { id: segment.id })
                this.loading = false
                if (!status) return showAlert.warning(message)
                let { id, index, title, type, value, rate, hex, image } = data
                this.modal.form = { id, index, title, type, value, rate, hex, image, image_upload: `` }
                this.modal.target.modal(`show`)
            },
            async submit(e) {
                e?.preventDefault()
                this.loading = true
                let endpoint = this.modal.form.id ? `segment/info/update` : `segment/add`
                let { status, message, data } = await post(endpoint, this.modal.form)
                this.loading = false
                if (!status) return showAlert.warning(message)
                let { id, index, title, type, value, rate, hex, image } = data
                this.modal.form = { id, index, title, type, value, rate, hex, image, image_upload: `` }
                let vm = this
                return showAlert.success(message, function() {
                    vm.list()
                    vm.modal.target.modal(`hide`)
                })
            },
            async save(e) {
                e?.preventDefault()
                this.loading = true
                let { status, message, data } = await post(`segment/list/update`, { wheel: this.wheel, segments: this.table.data })
                this.loading = false
                if (!status) return showAlert.warning(message)
                let vm = this
                return showAlert.success(message, function() {
                    vm.list()
                })
            },
            onFileChange(e) {
                e?.preventDefault()
                let row = e.target.dataset.row
                let files = e.target.files || e.dataTransfer.files
                if (!files.length) return
                this.createImage(files[0], row)
            },
            createImage(file, row) {
                let image = new Image()
                let reader = new FileReader()
                let vm = this

                reader.onload = (e) => {
                    vm.table.data[row].new_image = e.target.result
                }
                reader.readAsDataURL(file)
            },
            removeImage: function(e) {
                e?.preventDefault()
                let row = e.target.dataset.row
                this.table.data[row].new_image = ``
                $(`#image${row}`).val(``)
            },
        },
        async mounted() {
            this.modal.target = $(`#segment-modal`)
        }
    }).mount('#segment-box')
</script>

<?= $this->endSection() ?>