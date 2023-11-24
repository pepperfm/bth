import {createApp, h} from 'vue'
import * as ElementPlusIconsVue from '@element-plus/icons-vue'
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'
import {createInertiaApp} from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

import 'element-plus/dist/index.css'
import 'bootstrap/dist/css/bootstrap.min.css'
import '../scss/app.scss'

createInertiaApp({
  resolve: name => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
  setup({el, App, props, plugin}) {
    let app = createApp({render: () => h(App, props)})
    for (let i = 0; i < Object.entries(ElementPlusIconsVue).length; i++) {
      const [key, component] = Object.entries(ElementPlusIconsVue)[i]
      app.component(key, component)
    }
    app
      .use(plugin)
      .use(ElementPlus)
      .mount(el)

    return app
  },
})
