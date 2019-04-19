import { mount } from '@vue/test-utils'
import login from '../../../resources/src/js/router/views/login/index.vue'

test('Does login vue exist?', () => {
  var wrapper = mount(login)
  expect(wrapper.isVisible()).toBe(true)
})