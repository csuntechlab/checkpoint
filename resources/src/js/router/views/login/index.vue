<template>
    <form class="form-signin">
        <h1 class="h3 mb-3 font-weight-normal">Sign In</h1>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input
            type="email"
            id="inputEmail"
            class="form-control"
            placeholder="Email address"
            :value="form.email"
            @input="updateForm('email', $event.target.value)">
        <label for="password" class="sr-only">Password</label>
        <input
            type="password"
            id="password"
            class="form-control"
            placeholder="Password"
            :value="form.password"
            @input="updateForm('password', $event.target.value)">
        <button class="btn btn-lg btn-primary btn-block" type="submit" @click.prevent="formIsValid(form, login)">Sign in</button>
    </form>
</template>


<script>
import { validationMixin } from "vuelidate";
import { required,email, minLength } from "vuelidate/lib/validators";
import { formIsValid, updateForm } from '../../../utils';
import { mapActions } from 'vuex';
export default {
    data() {
        return {
            form: {
                email: null,
                password: null,
                showPassword: false,
            }
        };
    },
    validations: {
        form: {
            email: { required, email },
            password: { required, minLength: minLength(6) }
        }
    },
    methods: {
        ...mapActions([
            'login'
        ]),
        formIsValid,
        updateForm
    }
};
</script>
<style>
 .form-signin {
    width: 100%;
    max-width: 330px;
    padding: 15px;
    margin: 0 auto;
}
</style>

