<template>
  <v-content>
    <v-container>
      <v-layout align-start justify-start fill-heigh>
        <v-flex md12>
          <h1>Sign Up</h1>
        </v-flex>
      </v-layout>
      <v-form ref="form">
        <v-layout row wrap>
          <v-flex xs-12>
            <v-text-field
              v-model="organization_name"
              prepend-icon="business"
              label="Organization Name"
              required
            ></v-text-field>
            <v-text-field v-model="first_name" prepend-icon="person" label="First Name" required></v-text-field>
            <v-text-field v-model="last_name" prepend-icon="person" label="Last Name" required></v-text-field>
            <v-text-field v-model="email" prepend-icon="email" label="E-mail" required></v-text-field>
            <v-text-field
              v-model="password"
              :append-icon="showPassword ? 'visibility' : 'visibility_off'"
              :counter="0"
              :type="showPassword ? 'text':'password'"
              prepend-icon="lock"
              label="Password"
              required
              @click:append="showPassword = !showPassword"
            ></v-text-field>
            <v-text-field
              type="password"
              v-model="password_confirmation"
              prepend-icon="lock"
              label="Re-Type Password"
              required
            ></v-text-field>
            <v-text-field v-model="address_number" prepend-icon="place" label="Address Number"></v-text-field>
            <v-text-field v-model="street" prepend-icon="map" label="Street"></v-text-field>
            <v-text-field v-model="city" prepend-icon="location_city" label="City"></v-text-field>
            <v-text-field v-model="country" prepend-icon="place" label="Country"></v-text-field>
            <v-text-field v-model="zip_code" prepend-icon="place" label="Zip Code"></v-text-field>
            <v-text-field v-model="state" prepend-icon="place" label="State"></v-text-field>
            <img :src="imageUrl" height="150" v-if="imageUrl">
          </v-flex>
        </v-layout>
        <v-spacer></v-spacer>
        <v-layout>
          <v-flex>
            <v-btn color="teal lighten-3" @click="pickFile" v-model="imageFile">Upload Logo</v-btn>
            <input
              type="file"
              style="display: none"
              ref="image"
              accept="image/*"
              @change="onFilePicked"
            >
            <v-btn color="primary" @click="submit">Submit</v-btn>
          </v-flex>
        </v-layout>
      </v-form>
    </v-container>
  </v-content>
</template>

<script>
import { validationMixin } from "vuelidate";
import {
  alpha,
  alphaNum,
  email,
  minLength,
  numeric,
  required,
  sameAs
} from "vuelidate/lib/validators";
import axios from "axios";
import { resolve } from "q";

export default {
  mixins: [validationMixin],
  validations: {
    form: {
      organization_name: { alphaNum, required },
      first_name: { alpha, required },
      last_name: { alpha, required },
      email: { email, required },
      password: { minLength: minLength(6), required },
      password_confirmation: { sameAsPassword: sameAs("password"), required },
      address_number: { numeric, required },
      street: { alpha, required },
      city: { alpha, required },
      country: { alpha, required },
      zip_code: { numeric, required },
      state: { alpha, required }
    }
  },
  data() {
    return {
      showPassword: false,
      organization_name: null,
      first_name: null,
      last_name: null,
      email: null,
      password: null,
      password_confirmation: null,
      address_number: null,
      street: null,
      city: null,
      country: null,
      zip_code: null,
      state: null,
      imageName: null,
      imageUrl: null,
      imageFile: null
    };
  },
  computed: {},
  methods: {
    pickFile() {
      this.$refs.image.click();
    },
    onFilePicked(e) {
      const files = e.target.files;
      if (files[0] !== undefined) {
        this.imageName = files[0].name;
        if (this.imageName.lastIndexOf(".") <= 0) {
          return;
        }
        const fr = new FileReader();
        fr.readAsDataURL(files[0]);
        fr.addEventListener("load", () => {
          this.imageUrl = fr.result;
          this.imageFile = files[0];
        });
      } else {
        this.imageName = "";
        this.imageFile = "";
        this.imageUrl = "";
      }
    },
    submit() {
      axios
        .post("/api/register_admin", {
          organization_name: this.organization_name,
          first_name: this.first_name,
          last_name: this.last_name,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation,
          address_number: this.address_number,
          street: this.street,
          city: this.city,
          country: this.country,
          zip_code: this.zip_code,
          state: this.state,
          logo: this.imageFile
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
