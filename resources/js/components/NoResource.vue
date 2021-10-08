<template>
    <div class="w-full  h-96 flex items-center justify-center">
        <div
            class="w-full h-full bg-gray-50  text-center border shadow-sm rounded-sm text-l h-full
             text-gray-600 pt-48">
            No {{ resourceType }} registered yet.
            <div class="justify-center my-6" v-if="userType ==='admin'">
                <router-link
                    tag="button"
                    :to="{ name: toName }"
                    class="w-1/3 flex-auto text-center text-white h-12 rounded px-6 font-bold bg-green-500">
                    Create first {{ resourceType }}
                </router-link>
            </div>
        </div>

    </div>

</template>

<script>

import CustomIcon from './CustomIcon'
import { mapGetters } from 'vuex'

export default {
    name: 'NoResource',
    components: {
        CustomIcon
    },
    props: {
        resourceType: {
            type: String,
            required: true
        },
        toName: {
            type: String,
            required: true
        }
    },
    computed: {
        ...mapGetters({
            userType: 'user/getUserType',
        }),
    },
    methods: {
        createResource () {
        }
    }

}
</script>

<style scoped>

</style>