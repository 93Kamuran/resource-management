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
            meta: { layout: 'default', module: 'pdf' },
            props: true,
            component: () => import('./views/Resources/Pdf/index')
        },
        {
            path: '/pdf-resources/create',
            name: 'pdf-resource-create',
            meta: { layout: 'default' },
            component: () => import('./views/Resources/Pdf/create')
        },
        {
            path: '/html-snippets',
            name: 'html-snippets',
            meta: { layout: 'default', module: 'snippet' },
            props: true,
            component: () => import('./views/Resources/HtmlSnippet/index')
        },
        {
            path: '/html-snippets/create',
            name: 'html-snippet-create',
            meta: { layout: 'default' },
            component: () => import('./views/Resources/HtmlSnippet/create')
        },
        {
            path: '/links',
            name: 'links',
            meta: { layout: 'default', module: 'link' },
            props: true,
            component: () => import('./views/Resources/Link/index')
        },
        {
            path: '/links/create',
            name: 'link-create',
            meta: { layout: 'default' },
            component: () => import('./views/Resources/Link/create')
        }
    ]
})