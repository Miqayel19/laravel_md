<template>
    <div class="purchase-view" v-if="purchase">
        <form @submit.prevent="updateForm">
            <div v-if="errors.length" class="alert alert-danger" >
                <b>Please fix following errors</b>
                <ul>
                    <strong><li v-for="(error,index) in errors" :key="index">{{ error }}</li></strong>
                </ul>
                </div>
            <table class="table table-bordered">
                <tr>
                    <th>Customer Name</th>
                    <td>
                        <input type="text"  class="form-control" v-model="purchase.customerName">
                    </td>
                </tr>
                <tr>
                    <th>Quantity</th>
                    <td>
                        <input type="text"  class="form-control" v-model="purchase.quantity">
                    </td>
                </tr>
                <tr>
                    <th>Offering ID</th>
                    <td>
                        <select  v-model = "purchase.offeringID"  class="form-control" >
                            <option v-for="(offering,index) in offerings" :value="offering.id" :key="index">{{offering.title}}</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Action</th>
                    <td>
                        <input type="submit" value="Update" class="btn btn-primary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</template>

<script>
    export default {
        name: 'edit',
        created() {
            axios.get(`/api/purchases/${this.$route.params.id}`,{
                headers:{
                    "Authorization":`Bearer ${this.currentUser.token}`
                }
            }).then((response) => {
                    this.purchase = response.data.purchase
                });
            axios.get(`/api/offerings/`,{
                headers:{
                    "Authorization":`Bearer ${this.currentUser.token}`
                }
            }).then((response) => {
                this.offerings = response.data.offerings
            });
        },
        computed: {
            currentUser() {
                return this.$store.getters.currentUser;
            },
            purchases() {
                return this.$store.getters.purchases;
            },
        },
        data() {
            return {
                purchase: {
                    customerName:'',
                    quantity:'',
                    offeringID:''
                },
                offerings:[],
                errors: []
            };
        },
        methods:{

            updateForm: function (e) {

                if (!this.purchase.customerName) {
                    this.errors.push ("Customer Name required")
                }else if(this.purchase.customerName.length<3){
                    this.errors.push("Customer Name must contains minimum 3 characters")
                }
                if (!this.purchase.quantity) {
                    this.errors.push("Quantity required")
                }
                if (!this.errors.length) {
                    axios.put(`/api/purchases/${this.$route.params.id}`, this.$data.purchase,{
                        headers:{
                            'Authorization':`Bearer ${this.currentUser.token}`
                        }
                    })
                    .then((response) => {
                        this.$store.commit('updatePurchases',response.data.purchases);
                        this.$router.push('/purchases');
                    });
                }

                e.preventDefault();
            },

        }
    }
</script>
<style scoped>

    .table th{
        vertical-align:middle
    }

</style>
