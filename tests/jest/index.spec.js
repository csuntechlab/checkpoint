
import { mount } from '@vue/test-utils'
import App from '../../resources/src/js/App.vue'

test('Test App.Vue mount', () => {
  const wrapper = mount(App)

  expect(wrapper.isVisible()).toBe(true)
})
