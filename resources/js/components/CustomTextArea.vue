<template>
    <div>
        <div class="flex flex-col space-y-2">
            <label :for="label"
                   class="text-gray-700 select-none font-medium text-left pl-2">{{ label }}</label>
            <textarea
                class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-200"
                :rows="rows"
                :value="value"
                :name="label"
                @input="updateValue"
                v-on="listeners"
                v-bind="$attrs"
            />
        </div>
    </div>
</template>

<script>
export default {
    name: 'CustomTextArea',
    inheritAttrs: false,
    props: {
        label: {
            type: String,
            default: ''
        },
        rows: {
            type: String,
            default: 1
        },

        value: [String],
    },
    methods: {
        updateValue (event) {
            this.$emit('input', event.target.value)
        }
    },
    computed: {
        listeners () {
            return {
                ...this.$listeners,
                input: this.updateValue,
            }
        },
    }
}
</script>

<style scoped>

</style>