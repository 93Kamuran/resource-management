<template>
    <div class="w-full pr-8 pl-8  flex justify-center">
        <div class="w-full flex justify-start pl-8">
            <router-link
                v-if="!hiddenCreateButton"
                tag="button"
                :to="routeTo"
                class="w-3/12 p-1 items-center text-white rounded-lg bg-green-400">
                <custom-icon :name="iconName" width="2rem" height="2rem" class="pt-1"/>
            </router-link>
        </div>

    </div>
</template>

<script>
import CustomIcon from './CustomIcon'
import { mapGetters } from 'vuex'

export default {
    name: 'IndexContainer',
    components: {
        CustomIcon
    },
    props: {
        routeTo: {
            type: Object,
            required: true
        },
        hasBackPage: {
            type: Boolean,
            default: false
        }
    },
    computed: {
        iconName () {
            if (!this.hasBackPage) {
                return 'plus'
            }
            return 'arrow-left'
        },
        hiddenCreateButton () {
            return this.userType === 'visitor' && !this.hasBackPage;
        },
        ...mapGetters({
            userType: 'user/getUserType',
            pagination: 'paginate/getPagination'
        })
    }
}
</script>

<style scoped>

</style>