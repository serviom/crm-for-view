<template>
	<user-logs-list
		:user="this.$auth.user()"
	/>
</template>

<script>
import UserLogsList from "@/components/Pages/Dashboard/Users/UserLogsList";

export default {
    name: 'MyObjects',
	components: {UserLogsList}
}
</script>

<style scoped>

</style>
