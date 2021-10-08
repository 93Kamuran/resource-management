<template>
    <div class="flex flex-col space-y-2">
        <label class="inline-flex items-center">
            <input id="checkbox"
                   type="checkbox"
                   v-bind="$attrs"
                   @change="updateTarget"
                   class="form-checkbox"
                   :checked="isChecked"
                   v-on="$listeners"
            >
            <span class="ml-2">{{ label }}</span>
        </label>

    </div>
</template>

<script>


export default {
    inheritAttrs: false,
    name: 'CustomCheckBox',
    props: {
        type: {
            type: String,
            default: 'input'
        },
        label: {
            type: String,
            default: ''
        },
        value: {
            type: [String, Event]
        }
    },
    methods: {
        updateTarget (event) {
            if (event.target.checked) {
                this.$emit('target', '_blank')
            } else {

                this.$emit('target', '_self')
            }
        }
    },
    computed: {
        isChecked () {
            return this.value === '_blank'
        },

    }

}
</script>

<style scoped>

</style>