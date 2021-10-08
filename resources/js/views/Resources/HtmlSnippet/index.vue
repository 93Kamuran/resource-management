<template>
    <div>
        <div v-if="snippets.length>0" class="w-full h-full bg-gray-50
             text-center border space-y-4 text-gray-600 pt-12">
            <index-container   :route-to="{ name: 'html-snippet-create' }"/>
            <div v-if="userType==='admin'" class="flex w-full">
                <div v-if="isEditing" class="w-full  justify-center">
                    <html-snippet-form :snippet="snippet" @submit="submitForm(snippet)" @clear="clearForm"/>
                </div>
            </div>
            <custom-card
                resource-type="snippet"
                :resource="snippet"
                :card-class="cardClass"
                v-for="snippet in snippets"
                :key="snippet.id"
                @editResource="editResource">
                <html-snippet-content :snippet="snippet"/>
            </custom-card>
            <paginator :to="routeName"/>
        </div>
        <no-resource resource-type="Html Snippet" to-name="html-snippet-create" v-else/>
    </div>
</template>

<script>
import NoResource from '../../../components/NoResource'
import Paginator from '../../../components/Paginator'
import CustomCard from '../../../components/CustomCard'
import { mapGetters } from 'vuex'
import HtmlSnippetContent from '../../../components/HtmlSnippetContent'
import EventBus from '../../../event-bus'
import CustomIcon from '../../../components/CustomIcon'
import { RoutingMixin } from '../../../mixins/routingMixin'
import HtmlSnippetForm from '../../../components/HtmlSnippetForm'
import IndexContainer from '../../../components/IndexContainer'
export default {
    mixins: [RoutingMixin],
    name: 'index',
    components: {
        Paginator,
        CustomCard,
        CustomIcon,
        HtmlSnippetContent,
        NoResource,
        HtmlSnippetForm,
        IndexContainer
    },
    props: {
        page: {
            type: Number,
            default: 1
        }
    },
    data: () => {
        return {
            cardClass: 'border-solid border-2 border-green-500 h-96',
            routeName: 'html-snippets',
            isEditing: false,
            snippet: {
                id: '',
                title: '',
                description: '',
                html: '',
            }
        }
    },
    methods: {
        editResource (htmlSnippet) {
            this.isEditing = true
            this.snippet = {
                id: htmlSnippet.data.id,
                title: htmlSnippet.data.attributes.title,
                description: htmlSnippet.data.attributes.description,
                html: htmlSnippet.data.attributes.html,
            }

        },
        submitForm (htmlSnippet) {
            this.$store
                .dispatch('snippet/update', htmlSnippet)
                .then(() => {
                    EventBus.$emit('notify', 'Resource updated.', 'success')
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
            this.isEditing = false
        },
        clearForm () {
            this.refreshSnippet()
            this.isEditing = false
        },
        refreshSnippet () {
            this.snippet = {
                id: '',
                title: '',
                description: '',
                html: '',
            }
        }
    },
    computed: {
        ...mapGetters({
            snippets: 'snippet/getSnippets',
            userType: 'user/getUserType',
            pagination: 'paginate/getPagination'
        }),
    }
}
</script>

<style scoped>

</style>