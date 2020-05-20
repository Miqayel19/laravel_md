<template>
    <div>
        <div class="btn-wrapper">
            <router-link to="/purchases/new" class="btn btn-primary">New</router-link>
        </div>
        <table class="table">
            <template>
                <thead>
                    <th>Customer Name</th>
                    <th>Quantity</th>
                    <th>Offering ID</th>
                    <th colspan="3">Actions</th>
                </thead>
            </template>
            <tbody>
                <template v-if="!purchases.length">
                    <tr>
                        <td colspan="4" class="text-center">No purchases Available</td>
                    </tr>
                </template>
                <template v-else>
                    <tr v-for="purchase in purchases" :key="purchase.id">
                        <td>{{ purchase.customerName }}</td>
                        <td>{{ purchase.quantity }}</td>
                        <td>{{ purchase.offeringID }}</td>
                        <td>
                            <router-link :to="`/purchases/${purchase.id}`">Show</router-link>
                        </td>
                        <td>
                            <router-link :to="`/purchases/${purchase.id}/edit`">Edit</router-link>
                        </td>
                        <td>
                             <input type="submit" value="Delete"  @submit.prevent="deletePurchase(purchase.id)" class="btn btn-danger"/>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: 'list',
        mounted() {
            if (this.purchases.length) {
                return;
            }
            this.$store.dispatch('getPurchases');
        },
        computed:{
            purchases(){
                return this.$store.getters.purchases
            },
            currentUser(){
                return this.$store.getters.currentUser;
            }
        },
        methods:{
            deletePurchase(id){
                axios.delete('/api/purchases/' + id,{
                    headers:{
                        "Authorization":`Bearer ${this.currentUser.token}`,
                    }
                })
                .then(res => {  this.$store.commit('updatePurchases', res.data.purchases); })
                .catch(err => { console.error(err) })
            }
        }
    }
</script>
<style scoped>

    .btn-wrapper {
        text-align: right;
        margin-bottom: 20px;
    }

    table tr td{
        vertical-align:middle
    }

</style>
