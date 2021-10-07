import Vue from 'vue'
import Vuelidate from 'vuelidate'
import router from './router'
import App from './App'
import store from './store/store'
import 'vue-awesome/icons'
import Icon from 'vue-awesome/components/Icon'
import Notifications from 'vue-notification'
import VueSwal from 'vue-swal'

Vue.component('v-icon', Icon)
Vue.use(Vuelidate)
Vue.use(Notifications)
Vue.use(VueSwal)
require('./bootstrap')
window.Vue = require('vue').default
router.beforeEach((to, from, next) => {
    const userType = store.getters['user/getUserType']
    const pagination = store.getters['paginate/getPagination']
    if (to.name === 'login') {
        return next()
    }
    if (userType === '') {
        return next({ name: 'login' })
    }
    if (to.name === 'home' && Object.keys(to.params).length === 0) {
        return next({ name: 'pdf-resources', query: { limit: pagination.limit, page: 1 }, params: { page: 1 } })
    }
    next()

})
new Vue({
    el: '#app',
    components: {
        App
    },
    router,
    store,
    render: h => h(App),
})

