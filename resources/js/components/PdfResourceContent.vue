<template>
    <div>
        <div class=" w-full pl-2 mt-4 flex justify-items-start">
            <custom-icon name="file-pdf" width="auto" height="3rem"/>
        </div>
        <div class="w-full pl-2 mt-2 text-left">
            <a class="hover:text-blue-400 cursor-pointer" @click="download">Download</a>
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