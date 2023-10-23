<?= $this->extend("adminlte/layouts/blank") ?>

<?= $this->section("content") ?>

<div class="login-page">
    <div id="login-box" class="login-box">
        <div class="card">
            <div class="card-body login-card-body">
                <div class="login-logo">
                    <a>Admin <b>Protal</b></a>
                </div>
                <form @submit="submit">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" v-model="form.username" placeholder="Username">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" v-model="form.password" placeholder="Password">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block" :disabled="loading">Sign In</button>
                        </div>
                    </div>
                </form>
                <div class="p-2"></div>
                <p class="mb-1">
                    <a href="forgot-password">I forgot my password</a>
                </p>
                <p class="mb-0">
                    <a href="register" class="text-center">Register a new membership</a>
                </p>
            </div>
        </div>
    </div>
</div>
<script>
    Vue.createApp({
        data() {
            return {
                loading: false,
                form: {
                    username: ``,
                    password: ``,
                },
            }
        },
        methods: {
            async submit(e) {
                e?.preventDefault()
                this.loading = true
                let { status, message, data } = await post(`auth/login`, this.form)
                this.loading = false
                if (!status) return showAlert.warning(message)
                return showAlert.success(message, () => {
                    if (data?.url) open_link(data.url)
                }, 1000)
            }
        },
        mounted() {
            this.form.username = `<?= $username ?? "" ?>`
        }
    }).mount('#login-box')
</script>

<?= $this->endSection() ?>