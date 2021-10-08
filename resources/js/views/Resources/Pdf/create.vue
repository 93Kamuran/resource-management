<template>
    <div class="w-full h-full bg-gray-50
             text-center border space-y-4 text-gray-600 pt-12">
        <div class="w-full  justify-center">
            <index-container  :has-back-page="true" :route-to="{ name: 'pdf-resources',query:{limit:pagination.limit,page:pagination.page},params:{page:pagination.page} }"/>
        </div>
        <pdf-resource-form :pdf-resource="pdfResource" @submit="submitForm(pdfResource)" @clear="clearForm"/>
    </div>

</template>

<script>
import CustomButton from '../../../components/CustomButton'
import CustomInput from '../../../components/CustomInput'
import { mapGetters } from 'vuex'
import CustomIcon from '../../../components/CustomIcon'
import EventBus from '../../../event-bus'
import PdfResourceForm from '../../../components/PdfResourceForm'
import IndexContainer from '../../../components/IndexContainer'
export default {
    name: 'Create',
    components: {
        PdfResourceForm,
        CustomInput,
        CustomButton,
        CustomIcon,
        IndexContainer
    },
    data: () => {
        return {
            pdfResource: {
                file: null,
                title: '',
                fileName: '',
            }
        }
    },
    methods: {
        submitForm () {
            this.$store
                .dispatch('pdf/create', this.pdfResource)
                .then(() => {
                    EventBus.$emit('notify', 'Resource created.', 'success')
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
        },
        clearForm () {
            this.refreshPdfResource()
            this.$store.dispatch('pdf/setFileName', '')
        },
        refreshPdfResource () {
            this.pdfResource = {
                file: null,
                title: '',
                fileName: '',
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