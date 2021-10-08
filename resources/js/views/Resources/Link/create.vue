<template>
    <div class="w-full h-full bg-gray-50
             text-center border space-y-4 text-gray-600 pt-12">
        <div class="w-full  justify-center">
            <index-container :has-back-page="true"
                             :route-to="{ name: 'links',query:{limit:pagination.limit,page:pagination.page},params:{page:pagination.page} }"/>
        </div>

        <link-form :link="link" @submit="submitForm(link)" @clear="clearForm"/>
    </div>
</template>

<script>
import IndexContainer from '../../../components/IndexContainer'
import LinkForm from '../../../components/LinkForm'
import EventBus from '../../../event-bus'
import { mapGetters } from 'vuex'


export default {
    name: 'create',
    components: {
        IndexContainer,
        LinkForm
    },
    data: () => {
        return {
            link: {
                id: null,
                title: '',
                link: '',
                target: '_self',
            }
        }
    },
    methods: {
        submitForm () {
            this.$store
                .dispatch('link/create', this.link)
                .then(() => {
                    EventBus.$emit('notify', 'Resource created.', 'success')
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
        },
        clearForm () {
            this.refreshLink()
        },
        refreshLink () {
            this.link = {
                id: null,
                title: '',
                link: '',
                target: '_self',
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