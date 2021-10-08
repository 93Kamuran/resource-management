import apiClient from './Client/AxiosClient'

const resource = 'api/html-snippets'

export default {
    list (perPage, page) {
        return apiClient.get(`${resource}?limit=${perPage}&page=${page}`)
    },
    get (id) {
        return apiClient.get(`${resource}/${id}`)
    },
    post (htmlSnippet) {

        return apiClient.post(`${resource}`,htmlSnippet)
    },

    update (htmlSnippet) {

        return apiClient.put(`${resource}/${htmlSnippet.id}`,htmlSnippet)
    },
    delete (id) {
        return apiClient.delete(`${resource}/${id}`)
    },
}