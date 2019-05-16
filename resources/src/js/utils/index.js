//UTILS
//Utility/Helper Methods
import _ from 'lodash';

function formIsValid(data, submitForm, clearForm) {
    this.$v.$touch();
    if (!this.$v.$invalid) {
        submitForm(_.cloneDeep(data));
        this.$v.$reset();
        if (clearForm) {
            clearForm();
        }
    } else {
        console.log('form in error');
    }
}

function updateForm(field, data, parent) {
    if (parent) {
        this.form[parent][field] = data;
    } else {
        this.form[field] = data;
    }
}

export {
    formIsValid,
    updateForm
}
