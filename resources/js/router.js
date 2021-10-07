import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

export default new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home'
        },
        {
            path: '/login',
            name: 'login',
            component: () => import('./views/Login/index')
        },
        {
            path: '/pdf-resources',
            name: 'pdf-resources',
            meta: { layout: 'default' },
            props:true,
            component: () => import('./views/Resources/Pdf/index')
        },
        {
            path: '/pdf-resources/create',
            name: 'pdf-resource-create',
            meta: { layout: 'default' },
            component: () => import('./views/Resources/Pdf/create')
        }
    ]
})