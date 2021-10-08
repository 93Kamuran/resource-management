<template>
    <div class="w-full">

        <p class="text-left w-1/2 pl-4">Showing  {{ pagination.limit }} of {{ pagination.total }} resources</p>
        <div class="justify-end">
            <template>
                <router-link :is="pagination.page===1 ? 'span' : 'router-link'"
                             :to="{ name: to, query: { limit:pagination.limit, page: pagination.page - 1 } }"
                             rel="prev">
                    Prev Page
                </router-link>
                <template> |</template>
            </template>
            <router-link :is="!hasNextPage ? 'span' : 'router-link'"
                         :to="{ name: to, query: { limit:pagination.limit, page: pagination.page + 1 } }"
                         rel="next">
                Next Page
            </router-link>
        </div>


    </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
    name: 'Paginator',
    props: {
        to: {
            type: String,
            required: true
        }
    },
    computed: {
        hasNextPage () {
            return this.pagination.total > this.pagination.page * this.pagination.limit
        },
        ...mapGetters({
            pagination: 'paginate/getPagination'
        }),
    }
}
</script>

<style scoped>

</style>