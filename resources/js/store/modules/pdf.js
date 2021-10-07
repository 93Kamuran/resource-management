import PdfResourceService from '../../services/PdfResourceService'

export const namespaced = true

export const state = {
    resources: [],
    fileName: ''
}
export const mutations = {
    PUSH_RESOURCE (state, resource) {
        state.resources.push({
            data: resource.data,
            links: resource.links
        })
    },
    PUT_RESOURCE (state, resource) {
        state.resources = state.resources.reduce((acc, curr, i) => {

            if (curr.id === resource.id) {
                curr.data = resource.data
            }
            acc[i] = curr
            return acc
        }, [])
    },
    SET_RESOURCES (state, resources) {
        state.resources = resources
    },
    SET_FILE_NAME (state, fileName) {
        state.fileName = fileName
    },
    DELETE_RESOURCE (state, id) {
        state.resources = state.resources.filter(x => x.data.id !== id)
    },
}
export const actions = {
    create ({ commit }, resource) {
        return PdfResourceService.post(resource)
            .then((response) => {
                commit('PUSH_RESOURCE', response.data)
            })
            .catch(error => {
                throw error
            })
    },
    update ({ commit }, resource) {
        return PdfResourceService.update(resource)
            .then((response) => {
                commit('PUT_RESOURCE', response.data)
            })
            .catch(error => {
                throw error
            })
    },
    delete ({ commit }, id) {
        return PdfResourceService.delete(id)
            .then(() => {
                commit('DELETE_RESOURCE', id)
            })
            .catch(error => {
                throw error
            })
    },
    list ({ commit }, { limit, page }) {
        return PdfResourceService.list(limit, page)
            .then(response => {
                commit('SET_RESOURCES', response.data.data)
                return response.data
            })
            .catch(error => {
                throw error
            })
    },
    download ({ commit }, resource) {
        return PdfResourceService.get(resource)
            .then(() => {
            })
            .catch(error => {
                throw error
            })
    },
    setFileName ({ commit, dispatch }, fileName) {
        commit('SET_FILE_NAME', fileName)
    }
}
export const getters = {
    getResources: state => state.resources,
    getFilename: state => state.fileName
}
