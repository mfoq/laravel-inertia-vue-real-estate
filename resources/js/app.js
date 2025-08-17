import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue'
import { ZiggyVue } from 'ziggy'
import '../css/app.css'

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })

    const page = pages[`./Pages/${name}.vue`] //هذا انا خليته هيك عشان انفذ جزئية الديفولت لاي اوت اذا بديش اضل احط اللي اوت بكل كومبوننت
    page.default.layout = page.default.layout || MainLayout //هذا انا خليته هيك عشان انفذ جزئية الديفولت لاي اوت اذا بديش اضل احط اللي اوت بكل كومبوننت

    return page
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue)
      .mount(el)
  },
})
