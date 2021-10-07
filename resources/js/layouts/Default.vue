<template>
    <div class="w-2/4 container mx-auto bg-white p-4 min-h-full">
        <custom-navbar/>
        <div class="content">
            <slot/>
        </div>
    </div>
</template>
<script>

import CustomNavbar from '../components/CustomNavbar'

export default {
    name: 'default',
    components: {
        CustomNavbar
    }
}
</script>

<style scoped>

</style>