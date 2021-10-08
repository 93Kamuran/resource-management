import HtmlSnippetService from '../../services/HtmlSnippetService'


export const namespaced = true

export const state = {
    snippets: [],
}
export const mutations = {
    PUSH_SNIPPET (state, snippet) {
        state.snippets.push({
            data: snippet.data,
            links: snippet.links
        })
    },
    PUT_SNIPPET (state, snippet) {
        state.snippets = state.snippets.reduce((acc, curr, i) => {
            if (curr.id === snippet.id) {
                curr.data = snippet.data
            }
            acc[i] = curr
            return acc
        }, [])
    },
    SET_SNIPPETS (state, snippets) {
        state.snippets = snippets
    },
    DELETE_SNIPPET (state, id) {
        state.snippets = state.snippets.filter(x => x.data.id !== id)
    },
}
export const actions = {
    create ({ commit }, snippet) {
        return HtmlSnippetService.post(snippet)
            .then((response) => {
                commit('PUSH_SNIPPET', response.data)
            })
            .catch(error => {
                throw error
            })
    },
    update ({ commit }, snippet) {
        return HtmlSnippetService.update(snippet)
            .then((response) => {
                commit('PUT_SNIPPET', response.data)

            })
            .catch(error => {
                throw error
            })
    },
    delete ({ commit }, id) {
        return HtmlSnippetService.delete(id)
            .then(() => {
                commit('DELETE_SNIPPET', id)
            })
            .catch(error => {
                throw error
            })
    },
    list ({ commit }, { limit, page }) {
        return HtmlSnippetService.list(limit, page)
            .then(response => {
                commit('SET_SNIPPETS', response.data.data)
                return response.data
            })
            .catch(error => {
                throw error
            })
    },
}
export const getters = {
    getSnippets: state => state.snippets,
}