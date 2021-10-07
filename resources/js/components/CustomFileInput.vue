<template>
    <div v-if="!loading">
        <div class="container mx-auto w-full p1 h-48 min-h-4 border-dashed border-4 border-light-blue-500 mt-8 mb-8 p-0 outline-none bg-white">
            <input class="absolute h-40 p-0 outline-none opacity-0"
                   type="file" @change="uploadPfd" accept=".pdf" ref="file-input">
            <div class="pt-20">
                <p>Drag your file here or click in this area.</p>

                <p class="csv-p">
                    Only .pdf files.
                </p>
            </div>
        </div>
    </div>
</template>

<script>
import CustomButton from './CustomButton'

export default {
    name: 'CustomFileInput',
    components: {
        CustomButton
    },
    props:{
        file:{
          required:true
        },
        fileName:{
            type:String,
            default: ''
        },
        loading: {
            type:Boolean,
            default:false
        },
    },
    methods: {
        uploadPfd (event) {
            event.preventDefault()
            const fileLocation = event.type === 'change' ? 'srcElement' : 'dataTransfer'
            if (event[fileLocation].files.length !== 1) {
                let message = 'Only one file is supported'
                return
            }
            this.file = event[fileLocation].files[0]
            this.fileName = event[fileLocation].files[0].name
        },
    }
}
</script>

<style scoped>

</style>