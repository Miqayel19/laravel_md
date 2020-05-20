<template>
    <div  v-if="offering">
            <table class="table">
                <tr>
                    <th>ID</th>
                    <td>{{ offering.id }}</td>
                </tr>
                <tr>
                    <th>Price</th>
                    <td>{{ offering.price }}</td>
                </tr>
                <tr>
                    <th>Title</th>
                    <td>{{ offering.title }}</td>
                </tr>
            </table>
            <router-link to="/offerings">Back to all offerings</router-link>
    </div>
</template>

<script>
    export default {
        name: 'show',
        created() {
                axios.get(`/api/offerings/${this.$route.params.id}`,{
                    headers:{
                        "Authorization":`Bearer ${this.currentUser.token}`
                    }
                })
                .then((response) => {
                    this.offering = response.data.offering
                    console.log(response.data.offering);
                });
            },
        data() {
            return {
                offering: null
            };
        },
        computed: {
            currentUser() {
                return this.$store.getters.currentUser;
            },
        },
    }
</script>
<style scoped>

    .offering-view {
        display: flex;
        align-items: center;
    }

</style>
