<template>

    <div class="w-full h-screen flex items-center justify-center">
        <div class="w-full md:w-1/3 bg-gray-50 border shadow-sm rounded-sm ">
            <div class="flex font-bold justify-center mt-6">
                <img class="h-20 w-20"
                     src="https://raw.githubusercontent.com/sefyudem/Responsive-Login-Form/master/img/avatar.svg">
            </div>
            <div class="grid grid-cols-1 divide-y-2 divide-yellow-500">
                <div class="text-xl text-center text-gray-600 mb-4 ">Resource Management</div>
                <div class="px-12 pb-10">
                    <div class="w-full mb-2">
                        <div class="space-y-4">
                            <div class="justify-center my-6 ">
                                <custom-button
                                    buttonClass="w-full flex-auto pt-1 text-center text-white h-12 rounded px-6 font-bold bg-gray-700"
                                    @click="setUser('admin')">
                                    I'm an Admin !
                                </custom-button>
                            </div>
                            <div class="justify-center my-6">
                                <custom-button
                                    buttonClass="w-full flex-auto pt-1 text-center text-white h-12 rounded px-6 font-bold bg-gray-700"
                                    @click="setUser('visitor')">
                                    Continue as
                                    Visitor
                                </custom-button>
                            </div>

                        </div>

                    </div>

                </div>
            </div>


        </div>
    </div>

</template>

<script>
import CustomButton from './CustomButton'

export default {
    name: 'LoginCard',
    components: {
        CustomButton
    }, methods: {
        setUser (userType) {
            this.$emit('setStoredUser',userType)
        }
    }
}
</script>

<style scoped>

</style>