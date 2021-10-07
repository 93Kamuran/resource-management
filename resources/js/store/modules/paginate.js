export const namespaced = true
export const state = {
    pagination: {
        total: 0,
        page: 1,
        limit: 3
    }

}
export const mutations = {
    SET_PAGINATION (state, pagination) {
        state.pagination = pagination
    },
}
export const actions = {
    setPagination ({ commit },  pagination ) {
        commit('SET_PAGINATION',pagination)
    }
}
export const getters = {
    getPagination: state => state.pagination,
}