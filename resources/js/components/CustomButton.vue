<template>
        <button  v-bind="$attrs" v-on="$listeners" :class="buttonClass">
            <slot/>
        </button>
</template>

<script>
export default {
    name: 'CustomButton',
    inheritAttrs: false,
    props: {
        disabled: {
            type: Boolean,
            default: false,
        },
        buttonClass: {
            type: String,
            required: true
        },
    },
}
</script>

<style scoped>

</style>