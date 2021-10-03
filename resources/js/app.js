import Vue from 'vue'
import router from './router'
import App from './components/App'

require('./bootstrap')
window.Vue = require('vue').default

const app = new Vue({
    el: '#app',
    components: {
        App
    },
    router,
    render: h => h(App),
})
