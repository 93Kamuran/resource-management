<template>
    <div class="block w-full py-12 px-4">
        <div class="w-full justify-center">
            <custom-input type="text"
                          label="Title"
                          v-model="link.title"
                          @blur="$v.link.title.$touch()"
                          :class="{ error: $v.link.title.$error }"
            />
            <template v-if="$v.link.title.$error">
                <p v-if="!$v.link.title.required" class="text-left text-red-500">Title is required.</p>
            </template>
        </div>
        <div class="w-full justify-center">
            <custom-input type="text"
                          label="Link"
                          v-model="link.link"
                          @blur="$v.link.link.$touch()"
                          :class="{ error: $v.link.link.$error }"
            />
            <template v-if="$v.link.link.$error">
                <p v-if="!$v.link.link.required" class="text-left text-red-500">Link is required.</p>
                <p v-if="!$v.link.link.url" class="text-left text-red-500">Link is invalid.</p>
            </template>
        </div>
        <div class="w-full justify-center">
            <custom-check-box
                label="Open in a new tab"
                :value="link.target"
                @target="(target)=>link.target=target"/>
        </div>
        <div class="flex w-full justify-end space-x-4 mt-4">
            <custom-button
                button-class="w-3/12 p-8 items-left text-white rounded-lg bg-green-500"
                @click="submit">Save
            </custom-button>
            <custom-button button-class="w-3/12 p-8 items-right text-white rounded-lg bg-red-300"
                           @click="clear">
                clear
            </custom-button>

        </div>
    </div>
</template>

<script>
import CustomButton from './CustomButton'
import CustomInput from './CustomInput'
import { required } from 'vuelidate/lib/validators'
import CustomCheckBox from './CustomCheckBox'
import { helpers } from 'vuelidate/lib/validators'
const url = helpers.regex('url', /^(ftp|http|https):\/\/[^ "]+$/)
export default {
    name: 'LinkForm',
    components: {
        CustomCheckBox,
        CustomButton,
        CustomInput
    },
    props: {
        link: {
            type: Object,
            default: {
                id: null,
                title: '',
                link: '',
                target: '_self'
            }
        }
    },
    validations: {
        link: {
            title: { required },
            link: { required,url},
        }
    },
    methods: {
        async submit () {
            this.$v.link.title.$touch()
            this.$v.link.link.$touch()
            if (!this.$v.$invalid ) {
                this.$emit('submit', this.link)
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