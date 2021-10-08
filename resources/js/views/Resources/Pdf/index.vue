<template>
    <div>
        <div v-if="resources.length>0"
             class="w-full h-full bg-gray-50
             text-center border space-y-4 text-gray-600 pt-12">
            <index-container :route-to="{ name: 'pdf-resource-create' }"/>
            <div v-if="isEditing&&userType==='admin' " class="w-full justify-center">
                <pdf-resource-form :pdf-resource="pdfResource" @submit="submitForm(pdfResource)"
                                   @clear="clearForm"/>
            </div>

            <custom-card resource-type="pdf"
                         :resource="resource"
                         :card-class="cardClass"
                         v-for="resource in resources"
                         :key="resource.id"
                         @editResource="editResource">
                <pdf-resource-content :resource="resource"/>
            </custom-card>
            <paginator :to="routeName"/>
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
import PdfResourceContent from '../../../components/PdfResourceContent'
import CustomInput from '../../../components/CustomInput'
import { required } from 'vuelidate/lib/validators'
import PdfResourceForm from '../../../components/PdfResourceForm'
import EventBus from '../../../event-bus'
import { RoutingMixin } from '../../../mixins/routingMixin'
import IndexContainer from '../../../components/IndexContainer'

export default {
    mixins: [RoutingMixin],
    components: {
        IndexContainer,
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
    methods: {
        editResource (pdfResource) {
            this.isEditing = true
            this.pdfResource = {
                id: pdfResource.data.id,
                title: pdfResource.data.attributes.title,
            }
            this.$store.dispatch('pdf/setFileName', '')
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
                        if (error.name !== 'NavigationDuplicated') {
                            throw error
                        }
                    })
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