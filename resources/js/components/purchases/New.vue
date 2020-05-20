<template>
    <div class="purchase-new">
        <form @submit.prevent="submitForm">
            <div v-if="errors.length" class="alert alert-danger" >
                <b>Please fix following errors</b>
                <ul>
                    <strong><li v-for="(error,index) in errors" :key="index">{{ error }}</li></strong>
                </ul>
            </div>
            <table class="table">
                <tr>
                    <th>Customer Name</th>
                    <td>
                        <input type="text" class="form-control" v-model="purchase.customerName" placeholder="Customer Name"/>
                    </td>
                    <td>
                         <span v-if="errors.customerName">
                            {{ errors.customerName }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Quantity</th>
                    <td>
                        <input type="number" class="form-control" v-model="purchase.quantity" placeholder="Quantity"/>
                    </td>
                    <td>
                         <span v-if="errors.quantity">
                            {{ errors.quantity }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Offering ID</th>
                    <td>
                        <select  v-model = "purchase.offeringID"  class="form-control" >
                            <option  value="">Select one of answers</option>
                            <option v-for="(offering,index) in offerings" :value="offering.id" :key="index">{{offering.title}}</option>
                        </select>
                    </td>
                    <td>
                         <span v-if="errors.offeringID">
                            {{ errors.offeringID }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <router-link to="/purchases" class="btn btn-danger">Cancel</router-link>
                    </td>
                    <td class="text-right">
                        <input type="submit" value="Create" class="btn btn-primary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</template>

<script>
    export default {
        name:'new',
        mounted(){
            axios.get('/api/offerings',{
                headers:{
                    'Authorization':`Bearer ${this.currentUser.token}`
                }
            }).then((response) => {
               this.offerings= response.data.offerings;
            })
        },
        computed:{
            currentUser(){
                return this.$store.getters.currentUser;
            },
        },
        data() {
            return {
                purchase: {
                    customerName:'',
                    quantity:'',
                    offeringID: "",
                },
                offerings:[],
                errors: [],
            };
        },
        methods:{
            submitForm: function (e) {
                this.errors = [];
                if (!this.purchase.customerName) {
                    this.errors.push("Customer Name required")
                }else if(this.purchase.customerName.length<3){
                    this.errors.push("Customer Name must contains minimum 3 characters")
                }
                if (!this.purchase.quantity) {
                    this.errors.push("Quantity required")
                }else if(this.purchase.quantity.length<3){
                    this.errors.push("Quantity must contains minimum 3 characters")
                }
                if (!this.errors.length) {
                    console.log(this.$data.purchase);
                    axios.post('/api/purchases/new', this.$data.purchase,{
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
