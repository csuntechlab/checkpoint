<template>
  <v-content>
    <v-container fluid fill-height>
      <v-layout align-center justify-center>
        <v-flex xs12 sm8 md4>
          <v-card class="elevation-12">
            <v-toolbar dark color="primary">
              <v-toolbar-title>Login</v-toolbar-title>
              <v-spacer></v-spacer>
            </v-toolbar>
            <v-card-text>
              <v-form>
                <v-text-field
                  v-model="email"
                  prepend-icon="email"
                  :error-messages="emailErrors"
                  label="E-mail"
                  required
                  @input="$v.email.$touch()"
                  @blur="$v.email.$touch()"
                ></v-text-field>
                <v-text-field
                  v-model="password"
                  :append-icon="showPassword ? 'visibility' : 'visibility_off'"
                  :counter="0"
                  :type="showPassword ? 'text':'password'"
                  prepend-icon="lock"
                  :error-messages="passwordErrors"
                  label="Password"
                  required
                  @click:append="showPassword = !showPassword"
                  @input="$v.password.$touch()"
                  @blur="$v.password.$touch()"
                ></v-text-field>
                <v-spacer></v-spacer>

                <v-tooltip right>
                  <template v-slot:activator="{ on }">
                    <span v-on="on">Forgot Password?</span>
                  </template>
                  <span>Reset Password</span>
                </v-tooltip>
              </v-form>
            </v-card-text>
            <v-card-actions class="justify-center">
              <v-btn @click="submit" color="primary">Sign in</v-btn>
            </v-card-actions>
          </v-card>
          <v-layout class="mb-2">
            <v-flex>
              <v-btn icon flat href="/">
                <v-icon>arrow_back</v-icon>
              </v-btn>
              <span>Back to Home</span>
            </v-flex>
          </v-layout>
        </v-flex>
      </v-layout>
    </v-container>
  </v-content>
</template>

<script>
import { validationMixin } from "vuelidate";
import { required, minLength, email } from "vuelidate/lib/validators";
import axios from "axios";
import { resolve } from "q";

export default {
  mixins: [validationMixin],
  validations: {
    email: { required, email },
    password: { required, minLength: minLength(6) }
  },

  data() {
    return {
      showPassword: false,
      email: null,
      password: null
    };
  },

  computed: {
    passwordErrors() {
      const errors = [];
      if (!this.$v.password.$dirty) return errors;
      !this.$v.password.minLength &&
        errors.push("Password must be atleast 6 characters long");
      !this.$v.password.required && errors.push("Password is required.");
      return errors;
    },
    emailErrors() {
      const errors = [];
      if (!this.$v.email.$dirty) return errors;
      !this.$v.email.email && errors.push("Must be valid e-mail");
      !this.$v.email.required && errors.push("E-mail is required");
      return errors;
    }
  },

  methods: {
    submit() {
      axios
        .post('/api/login', {
          email: this.email,
          password: this.password
        })
        .then(function(response) {
          console.log(response.data);
        })
        .catch(function(error) {
          console.log(error.data);
        });
    }
  }
};
</script>

<style>
</style>
