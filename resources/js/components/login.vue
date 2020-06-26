<template>
  <div class="login-box">
    <div class="login-logo">
      <a>
        <b>GAMA</b>SPACE
      </a>
    </div>
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Ingresa las credenciales para iniciar la sección</p>
        <form method="POST" @submit.prevent="login" autocomplete="off">
          <div class="form-group">
            <input
              type="email"
              v-validate="'required|max:40|min:4'"
              class="form-control input-sm"
              :class="{
                                    'is-invalid':
                                        submitted && errors.has('email')
                                }"
              placeholder="Email"
              v-model="form.email"
              onfocus
              name="email"
            />
            <div
              v-if="submitted && errors.has('email')"
              class="invalid-feedback"
            >{{ errors.first("email") }}</div>
          </div>
          <div class="form-group">
            <input
              type="password"
              v-model="form.password"
              name="password"
              placeholder="Password"
              v-validate="'required|max:15|min:4'"
              class="form-control input-sm"
              :class="{
                                    'is-invalid':
                                        submitted && errors.has('password')
                                }"
            />
            <div
              v-if="submitted && errors.has('password')"
              class="invalid-feedback"
            >{{ errors.first("password") }}</div>
          </div>
          <div class="row">
            <div class="col-4" v-if="!status">
              <button
                type="submit"
                class="btn btn-primary btn-block"
                :disabled="errors.any()"
              >Ingresar</button>
            </div>
            <div class="col-4" v-else>
              <i class="fi fi-spinner-rotate-forward fi-spin"></i>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="alert alert-info alert-dismissible">
      <h5>
        <i class="icon fas fa-exclamation-triangle"></i>
      </h5>
      <strong>Gama space</strong> , sistema de facturación
    </div>
  </div>
</template>
<script>
export default {
  $_veeValidate: {
    validator: "new"
  },
  name: "login",
  data() {
    return {
      url: "login",
      submitted: true,
      status: false,
      form: {
        email: null,
        password: null
      }
    };
  },
  methods: {
    login() {
      this.$validator.validate().then(valid => {
        if (valid) {
          axios
            .post(this.url, {
              email: this.form.email,
              password: this.form.password
            })
            .then(response => {
              window.location.replace("home");
              this.status = true;
            })
            .catch(error => {
              this.form.password = null;
              Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Verifique las credenciales de ingreso"
              });
            });
        }
      });
    }
  }
};
</script>