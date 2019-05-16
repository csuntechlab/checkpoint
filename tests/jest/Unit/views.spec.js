import { mount } from '@vue/test-utils'
import login from '../../../resources/src/js/router/views/login/index.vue'
import admin from '../../../resources/src/js/router/views/admin/index.vue'
import Vue from 'vue';
import Vuetify from 'vuetify';
Vue.use(Vuetify);

test('Does login vue exist?', () => {
  var wrapper = mount(login)
  expect(wrapper.isVisible()).toBe(true)
})

test('Does admin vue exist?', () => {
  var wrapper = mount(admin)
  expect(wrapper.isVisible()).toBe(true)
})