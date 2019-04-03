// VALIDATORS
// Custom Form Data Validators For Vuelidate
// Source: https://monterail.github.io/vuelidate/#validators

import Vue from 'vue';
import moment from 'moment';
import Vuelidate from 'vuelidate';

// INIT VUELIDATE
Vue.use(Vuelidate);

const isDate = value => moment(value, 'YYYY-MM-DD', true).isValid();

export {
    isDate,
};
