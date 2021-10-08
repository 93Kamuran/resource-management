import apiClient from './Client/AxiosClient'

const resource = 'api/links'

export default {
    list (perPage, page) {
        return apiClient.get(`${resource}?limit=${perPage}&page=${page}`)
    },
    post (link) {
        return apiClient.post(`${resource}`, link)
    },
    update (link) {

        return apiClient.put(`${resource}/${link.id}`, link)
    },
    delete (id) {
        return apiClient.delete(`${resource}/${id}`)
    },
}