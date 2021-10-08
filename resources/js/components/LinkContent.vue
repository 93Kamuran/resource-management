<template>
    <div>

        <div class="w-full pl-2 mt-2 text-left">
            <a class="text-blue-400 hover:text-blue-700 cursor-pointer"
               :href="link.data.attributes.link"
               :target="link.data.attributes.target"
            >{{ link.data.attributes.link }}</a>

        </div>
    </div>
</template>

<script>
import CustomButton from './CustomButton'
import CustomIcon from './CustomIcon'

export default {
    name: 'LinkContent',
    props: {
        link: {
            type: Object,
            required: true
        }
    },
    components: {
        CustomButton,
        CustomIcon
    },
}
</script>

<style scoped>

</style>