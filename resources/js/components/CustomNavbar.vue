<template>
    <nav class="flex items-center justify-between flex-wrap bg-gray-600 p-6">
        <router-link class="flex items-center flex-shrink-0 text-white mr-6" to="/">
            <span class="font-semibold text-xl tracking-tight">Resource Management</span>
        </router-link>
        <div class="w-full block flex-grow md:flex md:justify-end md:w-auto">
            <div>
                <router-link :to="{ name: 'pdf-resources', query: { limit:pagination.limit, page: 1 } }"
                             :class="currentTab('pdf-resources')"
                             class="block md:inline-block text-sm px-4 py-2  rounded text-white border-white    hover:text-green-500 mt-4 md:mt-0">
                    Pdf Resources
                </router-link>
                <router-link to="/"
                             :class="currentTab('html-snippets')"

                             class="block md:inline-block text-sm px-4 py-2   rounded text-white border-white  hover:text-green-500 md:mt-0">
                    Html Snippets
                </router-link>
                <router-link to="/"
                             :class="currentTab('links')"
                             class="block md:inline-block text-sm px-4 py-2   rounded text-white border-white   hover:text-green-500 md:mt-0">
                    Links
                </router-link>
            </div>
        </div>
    </nav>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
    name: 'CustomNavbar',
    methods: {
        currentTab (tabName) {
            return tabName === this.$route.name ? 'text-green-500' : ''
        }
    },
    computed: {
        ...mapGetters({
            pagination: 'paginate/getPagination'
        })
    }
}
</script>

<style scoped>

</style>