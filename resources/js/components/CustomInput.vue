<template>
    <div>
        <div :class="frameClass">
            <label :for="label"
                   class="text-gray-700 select-none font-medium text-left pl-2">{{ label}}</label>
            <input
                id="default"
                :value="value"
                :type="type"
                :name="label"
                @input="updateValue"
                @change="updateFile"
                :placeholder="label"
                v-on="listeners"
                v-bind="$attrs"
                :class="inputClass"
            />
            <div class="pt-20" v-if="type ==='file'">
                <p>Drag your file here or click in this area.</p>
                <p v-text="fileName"></p>
                <p>Only .pdf files.</p>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
import EventBus from '../event-bus'

export default {
    name: 'CustomInput',
    inheritAttrs: false,
    props: {
        type: {
            type: String,
            default: 'input'
        },
        label: {
            type: String,
            default: ''
        },
        value: [String, Number, File],
    },
    methods: {
        updateFile () {
            if (this.type === 'file') {
                event.preventDefault()
                const fileLocation = event.type === 'change' ? 'srcElement' : 'dataTransfer'
                if (event[fileLocation].files.length !== 1) {
                    const message = 'Only one file is supported'
                    EventBus.$emit('notify', message, 'error')
                    return
                }
                this.$emit('file', event[fileLocation].files[0])
                this.$store.dispatch('pdf/setFileName', event[fileLocation].files[0].name)
            }
        },
        updateValue (event) {
            this.$emit('input', event.target.value)
        }
    },
    computed: {
        listeners () {
            return {
                ...this.$listeners,
                input: this.updateValue,
                change: this.updateFile
            }
        },
        inputClass () {
            if (this.type === 'file') {
                return 'absolute h-40 p-0 outline-none opacity-0'
            }
            return 'px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-200'
        },
        frameClass () {
            if (this.type === 'file') {
                return 'container mx-auto w-full p1 h-48 min-h-4 border-dashed border-4 ' +
                    'border-light-blue-500 mt-8 mb-8 p-0 outline-none bg-white'
            }
            return 'flex flex-col space-y-2'
        },
        ...mapGetters({
            fileName: 'pdf/getFilename'
        })

    }
}
</script>

<style scoped>

</style>