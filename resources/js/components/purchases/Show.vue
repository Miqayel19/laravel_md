<template>
    <div  v-if="purchase">
            <table class="table">
                <tr>
                    <th>ID</th>
                    <td>{{ purchase.id }}</td>
                </tr>
                <tr>
                    <th>Customer Name</th>
                    <td>{{ purchase.customerName }}</td>
                </tr>
                <tr>
                    <th>Quantity</th>
                    <td>{{ purchase.quantity }}</td>
                </tr>
                <tr>
                    <th>Offering ID</th>
                    <td>{{ purchase.offeringID }}</td>
                </tr>
            </table>
            <router-link to="/purchases">Back to all purchases</router-link>
    </div>
</template>

<script>
    export default {
        name: 'show',
        created() {
            if (this.purchases.length) {
                this.purchase = this.purchases.find((purchase) => purchase.id === this.$route.params.id);
            } else {
                axios.get(`/api/purchases/${this.$route.params.id}`,{
                    headers:{
                        "Authorization":`Bearer ${this.currentUser.token}`
                    }
                })
                .then((response) => {
                    this.purchase = response.data.purchase
                });
            }
        },
        data() {
            return {
                purchase: null
            };
        },
        computed: {
            currentUser() {
                return this.$store.getters.currentUser;
            },
            purchases() {
                return this.$store.getters.purchases;
            }
        },
    }
</script>
<style scoped>

    .purchase-view {
        display: flex;
        align-items: center;
    }

</style>
