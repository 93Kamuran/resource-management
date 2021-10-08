import LinkService from '../../services/LinkService'


export const namespaced = true

export const state = {
    links: [],
}
export const mutations = {
    PUSH_LINK (state, link) {
        state.links.push({
            data: link.data,
            links: link.links
        })
    },
    PUT_LINK (state, link) {
        state.links = state.links.reduce((acc, curr, i) => {
            if (curr.id === link.id) {
                curr.data = link.data
            }
            acc[i] = curr
            return acc
        }, [])
    },
    SET_LINKS (state, links) {
        state.links = links
    },
    DELETE_LINK (state, id) {
        state.links = state.links.filter(x => x.data.id !== id)
    },
}
export const actions = {
    create ({ commit }, link) {
        return LinkService.post(link)
            .then((response) => {
                commit('PUSH_LINK', response.data)
            })
            .catch(error => {
                throw error
            })
    },
    update ({ commit }, link) {
        return LinkService.update(link)
            .then((response) => {
                commit('PUT_LINK', response.data)
            })
            .catch(error => {
                throw error
            })
    },
    delete ({ commit }, id) {
        return LinkService.delete(id)
            .then(() => {
                commit('DELETE_LINK', id)
            })
            .catch(error => {
                throw error
            })
    },
    list ({ commit }, { limit, page }) {
        return LinkService.list(limit, page)
            .then(response => {
                commit('SET_LINKS', response.data.data)
                return response.data
            })
            .catch(error => {
                throw error
            })
    },
}
export const getters = {
    getLinks: state => state.links,
}