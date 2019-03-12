<template>
  <v-container>
    <v-layout align-start justify-start fill-heigh>
      <v-flex md12>
        <h1>Sign Up</h1>
      </v-flex>
    </v-layout>
    <v-layout align-start justify-start fill-heigh>
      <v-flex md>
        <v-form ref="form" v-model="valid" lazy-validation>
          <v-text-field v-model="organization" :rules="organizationRules" label="Organization Name" required></v-text-field>
          <v-text-field v-model="firstname" :rules="firstnameRules" label="First Name" required></v-text-field>
          <v-text-field v-model="lastname" :rules="lastnameRules" label="Last Name" required></v-text-field>
          <v-text-field v-model="email" :rules="emailRules" label="E-mail" required></v-text-field>
          <v-text-field type="password" v-model="password" label="Password" required></v-text-field>
          <v-text-field
            type="password"
            v-model="validatepassword"
            label="Re-Type Password"
            required
          ></v-text-field>
          <v-text-field v-model="address1" label="Address 1"></v-text-field>
          <v-text-field v-model="address2" label="Address 2"></v-text-field>
          <v-text-field v-model="city" label="City"></v-text-field>
          <v-text-field v-model="Country" label="Country"></v-text-field>
          <v-text-field v-model="zip" label="Zip Code"></v-text-field>

          <v-checkbox
            v-model="checkbox"
            :rules="[v => !!v || 'You must agree to continue!']"
            label="Do you agree?"
            required
          ></v-checkbox>

          <v-btn :disabled="!valid" color="success" @click="validate">Validate</v-btn>

          <v-btn color="error" @click="reset">Reset Form</v-btn>

          <v-btn color="warning" @click="resetValidation">Reset Validation</v-btn>
        </v-form>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    organzation: '',
    organizationRules: [v => !!v || 'Organization is required'],
    firstname: '',
    firstnameRules: [v => !!v || 'First name is required'],
    lastname: '',
    lastnameRules: [v => !!v || 'Last name is required'],
    email:'',
    emailRules: [
      v => !!v || 'E-mail is required',
      v => /.+@.+/.test(v) || 'E-mail must be valid'
    ]
    
    
  }),
  name: 'SignUp'
};
</script>
