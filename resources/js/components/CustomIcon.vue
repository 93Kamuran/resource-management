<template>
    <v-icon :name="name" :style="{width:width,height:height}"/>
</template>

<script>
export default {
    name: 'CustomIcon',
    props: {
        name: {
            type: String,
            required: true
        },
        width: {

            required: true
        },
        height: {

            required: true
        }
    }
}
</script>

<style scoped>

</style>