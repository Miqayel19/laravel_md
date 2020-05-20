<template>
    <div class="offering-view" v-if="offering">
        <form @submit.prevent="updateForm">
            <div v-if="errors.length" class="alert alert-danger" >
                <b>Please fix following errors</b>
                <ul>
                    <strong><li v-for="(error,index) in errors" :key="index">{{ error }}</li></strong>
                </ul>
                </div>
            <table class="table table-bordered">
                <tr>
                    <th>Title</th>
                    <td>
                        <input type="text"  class="form-control" v-model="offering.title">
                    </td>
                </tr>
                <tr>
                    <th>Price</th>
                    <td>
                        <input type="text" class="form-control" v-model="offering.price">
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
            axios.get(`/api/offerings/${this.$route.params.id}`,{
                headers:{
                    "Authorization":`Bearer ${this.currentUser.token}`
                }
            }).then((response) => {
                this.offering = response.data.offering
            });

        },
        computed: {
            currentUser() {
                return this.$store.getters.currentUser;
            },
        },
        data() {
            return {
                offering: {
                    title:'',
                    price:'',
                },
                errors: []
            };
        },
        methods:{
            updateForm: function (e) {
                if (!this.offering.title) {
                    this.errors.push ("Title required")
                }else if(this.offering.title.length<3){
                    this.errors.push("Title must contains  3 characters minimum")
                }
                if (!this.offering.price) {
                    this.errors.push("Price required")
                }else if(this.offering.price.length<3){
                    this.errors.push("Price must contains  3 characters minimum")
                }
                if (!this.errors.length) {
                    axios.put(`/api/offerings/${this.$route.params.id}`,this.offering,{
                        headers:{
                            'Authorization':`Bearer ${this.currentUser.token}`
                        }
                    })
                    .then((response) => {
                        this.$store.commit('updateOfferings',response.data.offerings);
                        this.$router.push('/offerings');
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
