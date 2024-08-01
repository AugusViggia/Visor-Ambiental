// Import modules...
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { InertiaProgress } from '@inertiajs/progress'
import Layout from '@/Layouts/AppLayout'
import { createPinia } from 'pinia'
import softUIDashboard from '@/Plugins/softUIDashboard'
import translation from '@/Plugins/translation'
import dateFormat from '@/Plugins/dateFormat'
import timestampFormat from '@/Plugins/timestampFormat'
import VueGates from 'vue-gates'
import auth from '@/Plugins/auth'

require('./bootstrap')

const appName = window.document.getElementsByTagName('title')[0]?.innerText || ''

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) => {
    const page = require(`@/Pages/${name}`).default
    page.layout = page.layout || Layout
    return page
  },
  setup ({ el, app, props, plugin }) {
    el.classList.add('g-sidenav-show')
    return createApp({ render: () => h(app, props) })
      .use(plugin)
      .use(createPinia())
      .use(softUIDashboard)
      .use(VueGates)
      .use(auth, props.initialPage.props.auth)
      .use(translation, props.initialPage.props.language)
      .use(dateFormat)
      .use(timestampFormat)
      // eslint-disable-next-line no-undef
      .mixin({ methods: { route } })
      .mount(el)
  },
})

InertiaProgress.init({ color: '#4B5563' })
