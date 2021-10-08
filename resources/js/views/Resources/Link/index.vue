<template>
    <div>
        <div v-if="links.length>0"
             class="w-full h-full bg-gray-50
             text-center border space-y-4 text-gray-600 pt-12">
            <index-container :route-to="{ name: 'link-create' }"/>
            <div v-if="isEditing&&userType==='admin' " class="w-full justify-center">
                <link-form :link="link" @submit="submitForm(link)" @clear="clearForm"/>
            </div>
            <custom-card resource-type="link"
                         :resource="link"
                         :card-class="cardClass"
                         v-for="link in links"
                         :key="link.id"
                         @editResource="editResource">
                <link-content :link="link"/>
            </custom-card>
            <paginator :to="routeName"/>
        </div>
        <no-resource resource-type="Link" to-name="link-create" v-else/>

    </div>
</template>

<script>
import LinkForm from '../../../components/LinkForm'
import { RoutingMixin } from '../../../mixins/routingMixin'
import IndexContainer from '../../../components/IndexContainer'
import { mapGetters } from 'vuex'
import CustomCard from '../../../components/CustomCard'
import NoResource from '../../../components/NoResource'
import Paginator from '../../../components/Paginator'
import EventBus from '../../../event-bus'
import LinkContent from '../../../components/LinkContent'

export default {
    name: 'index',
    mixins: [RoutingMixin],
    components: {
        LinkContent,
        IndexContainer,
        NoResource,
        CustomCard,
        Paginator,
        LinkForm
    },
    props: {
        page: {
            type: Number,
            default: 1
        }
    },
    data: () => {
        return {
            cardClass: 'border-solid border-2 border-blue-300 h-32',
            routeName: '',
            isEditing: false,
            link: {
                id: null,
                title: null,
                link: '',
                target: '',
            }
        }
    },
    methods: {
        editResource (link) {
            this.isEditing = true
            this.link = {
                id: link.data.id,
                title: link.data.attributes.title,
                link: link.data.attributes.link,
                target: link.data.attributes.target
            }
        },
        submitForm (link) {
            this.$store
                .dispatch('link/update', link)
                .then(() => {
                    EventBus.$emit('notify', 'Resource updated.', 'success')
                    this.$router.push({
                        name: 'links',
                        query: { limit: this.pagination.limit, page: this.pagination.page },
                        params: { page: this.pagination.page }
                    }).catch(error => {
                        if (error.name !== 'NavigationDuplicated') {
                            throw error
                        }
                    })
                    this.refreshLink()
                })
                .catch((e) => {
                    let errorMessage = e.response.data.message
                    EventBus.$emit('notify', errorMessage, 'error')
                })
            this.isEditing = false
        },
        clearForm () {
            this.refreshLink()
            this.isEditing = false
        },
        refreshLink () {
            this.link = {
                id: null,
                title: null,
                link: '',
                target: '_self',
            }
        }
    },
    computed: {
        ...mapGetters({
            links: 'link/getLinks',
            userType: 'user/getUserType',
            pagination: 'paginate/getPagination'
        }),
    }
}
</script>

<style scoped>

</style>