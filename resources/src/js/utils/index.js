//UTILS
//Utility/Helper Methods
function formIsValid(data, submitForm, clearForm) {
    this.$v.$touch();
    if (!this.$v.$invalid) {
        submitForm(_.cloneDeep(data));
        this.$v.$reset();
        if (clearForm) {
            clearForm();
        }
    } else {
        this.$store.dispatch('showAlert', { status: 'danger', message: 'Missing Required Fields! Try Again.' });
    }
}
export default {
    formIsValid
}
