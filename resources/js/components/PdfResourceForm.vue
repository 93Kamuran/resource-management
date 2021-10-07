<template>
    <div class="block w-full py-12 px-4">
        <div class="w-full justify-center">
            <custom-input type="text"
                          label="Title"
                          v-model="pdfResource.title"
                          @blur="$v.pdfResource.title.$touch()"
                          :class="{ error: $v.pdfResource.title.$error }"
            />
            <template v-if="$v.pdfResource.title.$error">
                <p v-if="!$v.pdfResource.title.required" class="text-left text-red-500">Title is required.</p>
            </template>
        </div>
        <div class="w-full justify-center">
            <custom-input type="file"
                          @file="changed"
                          v-model="pdfResource.fileName"
                          @blur="$v.pdfResource.fileName.$touch()"
                          :class="{ error: $v.pdfResource.fileName.$error }"/>

            <template v-if="$v.pdfResource.fileName.$error">
                <p v-if="!$v.pdfResource.fileName.required" class="text-left text-red-500">File is required.</p>
            </template>
        </div>
        <div class="flex w-full justify-end space-x-4">
            <custom-button
                button-class="w-3/12 p-8 items-left text-white rounded-lg bg-green-500"
                @click="submit">Upload File
            </custom-button>
            <custom-button button-class="w-3/12 p-8 items-right text-white rounded-lg bg-red-300"
                           @click="clear">
                clear
            </custom-button>

        </div>
    </div>
</template>

<script>
import { required } from 'vuelidate/lib/validators'
import CustomInput from './CustomInput'
import CustomButton from './CustomButton'

export default {
    name: 'PdfResourceForm',
    components: {
        CustomInput,
        CustomButton
    },
    props: {
        pdfResource: {
            type: Object,
            default: {
                id: null,
                file: null,
                title: '',
                fileName: '',
            }
        }
    }, validations: {
        pdfResource: {
            title: { required },
            fileName: { required },
        }
    },
    methods: {
        changed (file) {
            this.pdfResource.file = file
        },
        submit () {
            this.$v.pdfResource.fileName.$touch()
            this.$v.pdfResource.title.$touch()
            if (!this.$v.$invalid) {
                this.$emit('submit', this.pdfResource)
            }
        },
        clear () {
            this.$emit('clear')

        },
    }
}
</script>

<style scoped>

</style>