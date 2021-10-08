<template>
    <div class="w-full h-full bg-gray-50
             text-center border space-y-4 text-gray-600 pt-12">
        <div class="w-full  justify-center">
            <index-container :has-back-page="true"
                             :route-to="{ name: 'html-snippets',query:{limit:pagination.limit,page:pagination.page},params:{page:pagination.page} }"/>
        </div>

        <html-snippet-form :snippet="snippet" @submit="submitForm(snippet)" @clear="clearForm"/>
    </div>
</template>

<script>
import CustomIcon from '../../../components/CustomIcon'
import HtmlSnippetForm from '../../../components/HtmlSnippetForm'
import { mapGetters } from 'vuex'
import EventBus from '../../../event-bus'
import IndexContainer from '../../../components/IndexContainer'

export default {
    name: 'create',
    components: {
        HtmlSnippetForm,
        CustomIcon,
        IndexContainer
    },
    data: () => {
        return {
            snippet: {
                id: null,
                title: '',
                description: '',
                html: '',
            }
        }
    },
    methods: {
        submitForm () {
            this.$store
                .dispatch('snippet/create', this.snippet)
                .then(() => {
                    EventBus.$emit('notify', 'Resource created.', 'success')
                    this.$router.push({
                        name: 'html-snippets',
                        query: { limit: this.pagination.limit, page: this.pagination.page },
                        params: { page: this.pagination.page }
                    }).catch(error => {
                        if (error.name !== 'NavigationDuplicated') {
                            throw error
                        }
                    })
                    this.refreshSnippet()

                })
                .catch((e) => {
                    let errorMessage = e.response.data.message
                    EventBus.$emit('notify', errorMessage, 'error')
                })
        },
        clearForm () {
            this.refreshSnippet()
        },
        refreshSnippet () {
            this.snippet = {
                id: null,
                title: '',
                description: '',
                html: '',
            }
        }
    },
    computed: {
        ...mapGetters({
            userType: 'user/getUserType',
            pagination: 'paginate/getPagination'
        }),
    }
}
</script>

<style scoped>

</style>