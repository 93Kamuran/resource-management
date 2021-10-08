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
                <router-link :to="{ name: 'html-snippets', query: { limit:pagination.limit, page: 1 } }"
                             :class="currentTab('html-snippets')"
                             class="block md:inline-block text-sm px-4 py-2   rounded text-white border-white  hover:text-green-500 md:mt-0">
                    Html Snippets
                </router-link>
                <router-link :to="{ name: 'links', query: { limit:pagination.limit, page: 1 } }"
                             :class="currentTab('links')"
                             class="block md:inline-block text-sm px-4 py-2   rounded text-white border-white   hover:text-green-500 md:mt-0">
                    Links
                </router-link>

                <router-link
                    tag="button"
                    to="/login"
                    class="block md:inline-block bg-transparent p-2 items-center text-white rounded-lg border border-white">
                    <custom-icon name="sign-out-alt" width="2rem" height="2rem" class="pt-1"/>
                </router-link>

            </div>
        </div>
    </nav>
</template>

<script>
import { mapGetters } from 'vuex'
import CustomIcon from './CustomIcon'

export default {
    name: 'CustomNavbar',
    components: {
        CustomIcon
    },
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