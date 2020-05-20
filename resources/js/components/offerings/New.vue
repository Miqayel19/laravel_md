<template>
    <div class="offering-new">
        <form @submit.prevent="submitForm">
            <div v-if="errors.length" class="alert alert-danger" >
                <b>Please fix following errors</b>
                <ul>
                    <strong><li v-for="(error,index) in errors" :key="index">{{ error }}</li></strong>
                </ul>
            </div>
            <table class="table">
                <tr>
                    <th>Title</th>
                    <td>
                        <input type="text" class="form-control" v-model="offering.title" placeholder="Title"/>
                    </td>
                    <td>
                         <span v-if="errors.title">
                            {{ errors.title }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Price</th>
                    <td>
                        <input type="number" class="form-control" v-model="offering.price" placeholder="Price"/>
                    </td>
                    <td>
                         <span v-if="errors.price">
                            {{ errors.price }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <router-link to="/offerings" class="btn btn-danger">Cancel</router-link>
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
        computed:{
            currentUser(){
                return this.$store.getters.currentUser;
            }
        },
        data() {
            return {
                offering: {
                    title:'',
                    price:'',
                },
                errors: [],
            };
        },
        methods:{
            submitForm: function (e) {
                this.errors = [];

                if (!this.offering.title) {
                    this.errors.push("Title required")
                }else if(this.offering.title.length<3){
                    this.errors.push("Title must contains  3 characters minimum")
                }
                if (!this.offering.price) {
                    this.errors.push("Price required")
                }else if(this.offering.price.length<3){
                    this.errors.push("Price must contains  3 digits minimum")
                }
                if (!this.errors.length) {
                    axios.post('/api/offerings/new', this.offering,{
                        headers:{
                            'Authorization':`Bearer ${this.currentUser.token}`
                        }
                    })
                    .then((response) => {
                        this.$store.commit('updateOfferings',response.data.offerings);
                        this.$router.push('/offerings');
                    });
                }
            },
        }
    }
</script>
