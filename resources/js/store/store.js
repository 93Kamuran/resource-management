import Vue from 'vue'
import Vuex from 'vuex'

import * as user from './modules/user'
import * as pdf from './modules/pdf'
import * as paginate from './modules/paginate'
import * as snippet from './modules/snippet'
import * as link from './modules/link'

import VuexPersist from 'vuex-persist'

Vue.use(Vuex)
const vuexLocalStorage = new VuexPersist({
    reducer: (state) => ({
        user: {
            userType: state.user.userType,
        },
        pagination: {
            pagination: state.paginate.pagination
        }
    }),
    key: 'vuex',
    storage: window.localStorage,
})
export default new Vuex.Store({
    modules: {
        user,
        pdf,
        paginate,
        snippet,
        link
    },
    plugins: [vuexLocalStorage.plugin],
})


