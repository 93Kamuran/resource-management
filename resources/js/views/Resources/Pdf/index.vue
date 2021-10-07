<template>
    <div>

        <div v-if="resources.length>0"
             class="w-full h-full bg-gray-50
             text-center border space-y-4 text-gray-600 pt-12">
            <div v-if="userType==='admin'" class="flex w-full py-12 px-4">
                <div v-if="isEditing" class="w-full  justify-center">
                    <pdf-resource-form :pdf-resource="pdfResource" @submit="submitForm(pdfResource)"
                                       @clear="clearForm"/>
                </div>
                <div v-if="!isEditing" class="w-full flex justify-center">
                    <div class="w-1/2 justify-center">
                        <h2 class="text-2xl font-extrabold justify-start">
                            <span class="block">Create New Resource</span>
                        </h2>
                    </div>
                    <div class="w-1/2 justify-center">
                        <router-link
                            tag="button"
                            :to="{ name: 'pdf-resource-create' }"
                            class="w-3/12 p-1 items-center text-white rounded-lg bg-green-500">
                            <custom-icon name="plus" width="2rem" height="2rem" class="pt-1"/>
                        </router-link>

                    </div>
                </div>

            </div>
            <custom-card :card-class="cardClass" v-for="resource in resources" :key="resource.id">
                <pdf-resource-content :resource="resource" @editResource="editResource"/>
            </custom-card>
            <paginator :to="routeName" subscribe-to="pdf"/>
        </div>
        <no-resource resource-type="PDF file" to-name="pdf-resource-create" v-else/>

    </div>
</template>

<script>
import NoResource from '../../../components/NoResource'
import CustomCard from '../../../components/CustomCard'
import CustomIcon from '../../../components/CustomIcon'
import CustomButton from '../../../components/CustomButton'
import { mapGetters } from 'vuex'
import Paginator from '../../../components/Paginator'
import store from '../../../store/store'
import PdfResourceContent from '../../../components/PdfResourceContent'
import CustomInput from '../../../components/CustomInput'
import { required } from 'vuelidate/lib/validators'
import PdfResourceForm from '../../../components/PdfResourceForm'
import EventBus from '../../../event-bus'

function getResources (routeTo, next) {
    const page = parseInt(routeTo.query.page)
    const limit = parseInt(routeTo.query.limit)
    store
        .dispatch('pdf/list', {
            limit: routeTo.query.limit,
            page: page
        })
        .then((response) => {
            store
                .dispatch('paginate/setPagination', {
                    total: response.meta.total,
                    page: page,
                    limit: limit
                })
            routeTo.params.page = page
            next()
        })
}

export default {
    components: {
        PdfResourceContent,
        Paginator,
        NoResource,
        CustomCard,
        CustomButton,
        CustomIcon,
        CustomInput,
        PdfResourceForm
    },
    props: {
        page: {
            type: Number,
            default: 1
        }
    },
    validations: {
        pdfResource: {
            title: { required },
            fileName: { required },
        }
    },
    data: () => {
        return {
            cardClass: 'border-solid border-2 border-red-300',
            routeName: '',
            isEditing: false,
            pdfResource: {
                id: null,
                file: null,
                title: '',
                fileName: '',
            }
        }
    },
    beforeRouteEnter (routeTo, routeFrom, next) {
        getResources(routeTo, next)
    },
    beforeRouteUpdate (routeTo, routeFrom, next) {
        getResources(routeTo, next)
    },
    methods: {
        editResource (pdfResource) {
            this.isEditing = true
            this.pdfResource = {
                id: pdfResource.data.id,
                title: pdfResource.data.attributes.title,
            }
            this.$store.dispatch('pdf/setFileName','')
        },
        submitForm (pdfResource) {
            this.$store
                .dispatch('pdf/update', pdfResource)
                .then(() => {
                    EventBus.$emit('notify', 'Resource updated.', 'success')
                    this.$router.push({
                        name: 'pdf-resources',
                        query: { limit: this.pagination.limit, page: this.pagination.page },
                        params: { page: this.pagination.page }
                    }).catch(error => {
                        if (error.name !== "NavigationDuplicated") {
                            throw error;
                        }
                    });
                    this.refreshPdfResource()
                })
                .catch((e) => {

                    let errorMessage = e.response.data.message
                    EventBus.$emit('notify', errorMessage, 'error')
                })
            this.isEditing = false
        },
        clearForm () {
            this.refreshPdfResource()
            this.$store.dispatch('pdf/setFileName', '')
            this.isEditing = false
        },
        refreshPdfResource () {
            this.pdfResource = {
                id: null,
                file: null,
                title: '',
                fileName: '',
            }
        }
    },
    computed: {
        ...mapGetters({
            resources: 'pdf/getResources',
            userType: 'user/getUserType',
            pagination: 'paginate/getPagination'
        }),
    }
}
</script>

<style scoped>

</style>