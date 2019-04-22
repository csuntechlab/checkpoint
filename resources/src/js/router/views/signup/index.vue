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
            <v-text-field v-model="organization_name" label="Organization Name" required></v-text-field>
            <v-text-field v-model="first_name" label="First Name" required></v-text-field>
            <v-text-field v-model="last_name" label="Last Name" required></v-text-field>
            <v-text-field v-model="email" label="E-mail (This will be your username)" required></v-text-field>
            <v-text-field type="password" v-model="password" label="Password" required></v-text-field>
            <v-text-field
              type="password"
              v-model="password_confirmation"
              label="Re-Type Password"
              required
            ></v-text-field>
            <v-text-field v-model="address_number" label="Address Number"></v-text-field>
            <v-text-field v-model="street" label="Street"></v-text-field>
            <v-text-field v-model="city" label="City"></v-text-field>
            <v-text-field v-model="country" label="Country"></v-text-field>
            <v-text-field v-model="zip_code" label="Zip Code"></v-text-field>
            <v-text-field v-model="state" label="State"></v-text-field>
            <img :src="imageUrl" height="150" v-if="imageUrl">
          </v-flex>
        </v-layout>
        <v-spacer></v-spacer>
        <v-layout>
          <v-flex>
            <v-btn color="teal lighten-3" @click="pickFile" v-model="imageName">Upload Logo</v-btn>
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
import { required } from "vuelidate/lib/validators";
import axios from "axios";
export default {
  data: () => ({
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
  }),
  validations: {
    form: {
      organization_name: { required },
      first_name: { required },
      last_name: { required },
      email: { required },
      password: { required },
      password_confirmation: { required },
      address_number: { required },
      street: { required },
      city: { required },
      country: { required },
      zip_code: { required },
      state: { required }
    }
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
          this.imageFile = files[0]; // this is an image file that can be sent to server...
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
          logo: this.imagefile
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
