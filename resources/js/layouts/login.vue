<template>
  <v-container fluid fill-height>
    <v-row align="center" justify="center">
      <v-col cols="12" sm="8" md="4">
        <v-card class="pa-4" elevation="10">
          <v-card-title class="d-flex justify-center font-weight-bold text-h5">
            Task Management
          </v-card-title>

          <v-card-text>
            <v-form ref="loginForm" v-model="formValid" @submit.prevent="handleLogin">
              <v-text-field
                v-model="email"
                label="Email"
                type="email"
                variant="outlined"
                :rules="emailRules"
                required
                class="mb-4"
              ></v-text-field>
              <v-text-field
                v-model="password"
                label="Password"
                type="password"
                variant="outlined"
                :rules="passwordRules"
                required
              ></v-text-field>
              <v-btn
                type="submit"
                color="primary"
                block
                class="mt-4"
                :disabled="!formValid"
              >
                Login
              </v-btn>
            </v-form>
          </v-card-text>

          
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";

export default {
  data() {
    return {
      email: "",
      password: "",
      formValid: false,
      emailRules: [
        v => !!v || "Email is required",
        v => /.+@.+\..+/.test(v) || "E-mail must be valid"
      ],
      passwordRules: [
        v => !!v || "Password is required",
        v => v.length >= 6 || "Password must be at least 6 characters"
      ]
    };
  },
  methods: {
    handleLogin() {
      var self = this;

      if (this.$refs.loginForm.validate()) {
        axios.post('/api/login', {
            email: self.email,
            password: self.password
        })
        .then(response => {
          // console.log("response.data.access_token", response.data.access_token)
          localStorage.setItem('token_id', response.data.access_token);

          this.$router.push('/task');
        })
        .catch(error => {
          Swal.fire({
              title: "Login Failed",
              text: "Your email or password wrong!",
              icon: "warning"
          });
        })
                
      }
    }
  }
};
</script>


<style scoped>
.v-container {
  min-height: 100vh;
}
</style>