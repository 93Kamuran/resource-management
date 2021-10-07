export const namespaced = true

export const state = {
    userType: '',
}
export const mutations = {
    LOGGED_IN (state, userType) {
        state.userType = userType
    },

}
export const actions = {
    logIn ({ commit }, userType) {
        commit('LOGGED_IN', userType)
    },
    logOut ({ commit }) {
        commit('LOGGED_IN', '')
    },
}
export const getters = {
    getUserType: state => {
        return state.userType
    },
}
