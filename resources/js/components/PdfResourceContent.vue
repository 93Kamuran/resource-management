<template>
    <div>
        <div class="flex flex-col p-1">
            <div>
                <div class="flex w-full ">
                    <p class="text-2xl w-2/4 underline font-bold text-gray-600 text-left ">
                        {{ resource.data.attributes.title }}</p>
                    <div v-if="userType==='admin'" class="w-2/4  flex justify-end">
                        <custom-button buttonType="submit"
                                       buttonClass="w-2/12  pt-1 mr-1 items-end text-white rounded p-1  bg-gray-700"
                                       @click="editResource">
                            <custom-icon name="edit" width="1rem" height="1rem"/>
                        </custom-button>

                        <custom-button buttonType="submit"
                                       buttonClass="w-2/12 pt-1 mr-1 items-end text-white rounded p-1 bg-red-700"
                                       @click="deleteResource">
                            <custom-icon name="trash-alt" width="1rem" height="1rem"/>
                        </custom-button>
                    </div>
                </div>
                <div class="text-md text-gray-600 text-right min-h-4">
                        <span class="block w-full">
                            Created at {{ resource.data.attributes.created }}
                        </span>
                    <span class="block w-full" v-if="modified">
                           Modified {{ resource.data.attributes.modified }}
                        </span>
                </div>
            </div>
            <div class=" pl-2 mt-4 flex justify-items-start">
                <custom-icon name="file-pdf" width="auto" height="3rem"/>
            </div>
            <a class="pl-2 mt-2 text-left hover:text-blue-400" @click="download">
                Download
            </a>
        </div>
    </div>
</template>

<script>
import CustomButton from './CustomButton'
import CustomIcon from './CustomIcon'
import { mapGetters } from 'vuex'
import EventBus from '../event-bus'


export default {
    name: 'PdfResourceContent',
    components: { CustomIcon, CustomButton },
    props: {
        resource: {
            type: Object,
            required: true
        }
    },
    methods: {
        download () {
            window.open(`api/pdf-resources/${this.resource.data.id}/download`)
        },
        deleteResource () {
            this.$swal({
                title: 'Are you sure?',
                text: 'Once deleted, you will not be able to recover this resource !',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        this.$store.dispatch('pdf/delete', this.resource.data.id).then(() => {
                            this.$swal('Poof! Your resource  has been deleted!', {
                                icon: 'success',
                            })
                        }).catch((e) => {

                            let errorMessage = e.response.data.message
                            EventBus.$emit('notify', errorMessage, 'error')
                        })
                    } else {
                        this.$swal('Your source file is safe!')
                    }
                })
        },
        editResource(){
            this.$emit('editResource',this.resource)
        }
    },
    computed: {
        modified () {
            return this.resource.data.attributes.created !== this.resource.data.attributes.modified
        },
        ...mapGetters({
            userType: 'user/getUserType'
        })
    }

}
</script>

<style scoped>

</style>