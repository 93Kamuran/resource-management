<template>
    <div class="block w-full py-12 px-4">
        <div class="w-full justify-center">
            <custom-input type="text"
                          label="Title"
                          v-model="snippet.title"
                          @blur="$v.snippet.title.$touch()"
                          :class="{ error: $v.snippet.title.$error }"
            />
            <template v-if="$v.snippet.title.$error">
                <p v-if="!$v.snippet.title.required" class="text-left text-red-500">Title is required.</p>
            </template>
        </div>
        <div class="w-full justify-center">
            <custom-text-area label="Description"
                              rows="2"
                              v-model="snippet.description"
                              @blur="$v.snippet.description.$touch()"
                              :class="{ error: $v.snippet.description.$error }"/>
            <template v-if="$v.snippet.description.$error">
                <p v-if="!$v.snippet.description.required" class="text-left text-red-500">Description is
                    required.</p>
            </template>


        </div>
        <div class="w-full justify-center ">
            <div class="flex flex-col space-y-2">
                <custom-text-area label="Html"
                                  rows="8"
                                  v-model="snippet.html"
                                  @blur="$v.snippet.html.$touch()"
                                  :class="{ error: $v.snippet.html.$error }"/>
                <template v-if="$v.snippet.html.$error">
                    <p v-if="!$v.snippet.html.required" class="text-left text-red-500"> Html is required. </p>
                </template>
                <template v-if="!isHtmlValid">
                    <p class="text-left text-red-500"> Html is invalid</p>
                </template>
            </div>
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
import CustomIcon from './CustomIcon'
import CustomInput from './CustomInput'
import { required } from 'vuelidate/lib/validators'
import CustomTextArea from './CustomTextArea'

const htmlTagValidator = require('html-tag-validator')

export default {
    name: 'HtmlSnippetForm',
    components: {
        CustomTextArea,
        CustomInput,
        CustomButton,
        CustomIcon
    },
    props: {
        snippet: {
            type: Object,
            default: {
                id: null,
                title: '',
                description: '',
                html: ''
            }
        },

    }, validations: {
        snippet: {
            title: { required },
            description: { required },
            html: { required },
        }
    },
    data: () => {
        return {
            isHtmlValid: true
        }
    },
    methods: {
        async submit () {
            this.$v.snippet.title.$touch()
            this.$v.snippet.description.$touch()
            this.$v.snippet.html.$touch()
            try {
                await this.validateHtmlSnippet()
                this.isHtmlValid = true
            } catch (err) {
                this.isHtmlValid = false
            }
              if (!this.$v.$invalid && this.isHtmlValid) {
                  this.$emit('submit', this.snippet)
              }
        },
        clear () {
            this.$emit('clear')
        },
        validateHtmlSnippet () {
            if (this.snippet.html[0] !== '<')
                throw new Error('invalid html')
            return new Promise((resolve, reject) => {
                htmlTagValidator(this.snippet.html, function (err, ast) {
                    if (err) {
                        reject(err.message)
                    } else {
                        resolve(true)
                    }
                })
            })
        },

    }
}
</script>

<style scoped>

</style>