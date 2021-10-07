<template>
    <login-card @setStoredUser="setStoredUser"/>
</template>

<script>
import LoginCard from '../../components/LoginCard'

export default {

    components: {
        LoginCard
    },
    created () {
        this.$store.dispatch('user/logOut')
    }, methods: {
        setStoredUser (userType) {
            this.$store.dispatch('user/logIn', userType)
            this.$router.push({ name: 'home' }).catch((error) => {console.log('Navigation redirected')});
        }
    }
}
</script>

<style scoped>

</style>