import apiClient from './Client/AxiosClient'

const resource = 'api/pdf-resources'

export default {
    list (perPage, page) {
        return apiClient.get(`${resource}?limit=${perPage}&page=${page}`)
    },
    get (id) {
        return apiClient.get(`${resource}/${id}`)
    },
    post (pdfResource) {
        let formData = new FormData()
        formData.append('file', pdfResource.file)
        formData.append('title', pdfResource.title)
        return apiClient.post(`${resource}`, formData,
            { header: { 'Content-Type': 'multipart/form-data' } })
    },

    update (pdfResource) {
        let formData = new FormData()
        formData.append('file', pdfResource.file)
        formData.append('title', pdfResource.title)
        return apiClient.post(`${resource}/${pdfResource.id}`, formData,
            { header: { 'Content-Type': 'multipart/form-data' } })
    },
    delete (id) {
        return apiClient.delete(`${resource}/${id}`)
    },
}