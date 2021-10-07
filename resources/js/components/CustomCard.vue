<template>
    <div v-bind="$attrs" :class="cardClass" class="container mx-auto
       box-content h-48 hover:h-34 w-3/4  hover:shadow-lg
       shadow-md bg-white
       items-center p-10 justify-center">
        <div>
            <slot/>
        </div>
    </div>
</template>

<script>
export default {
    name: 'CustomCard',
    props: {
        cardClass: {
            type: String
        }
    }
}
</script>

<style scoped>

</style>