<template>
    <div>
        <component :is="layout">
            <router-view/>
        </component>
        <notifications group="notify" position="bottom right"/>
    </div>

</template>

<script>
const defaultLayout = 'default'
import Default from './layouts/Default'
import EventBus from './event-bus'
export default {
    name: 'App',
    components: {
        Default
    },
    mounted () {
        EventBus.$on('notify', (message, type) => {
            this.$notify({
                group: 'notify',
                type: type,
                title: type + ' !',
                text: message
            })
        })
    },
    computed: {
        layout () {
            if (this.$route.meta.layout === defaultLayout) {
                return defaultLayout
            }
            return 'div'
        }
    },
}
</script>
<style>

</style>

