<template>
    <div>
        <div class="btn-wrapper">
            <router-link to="/offerings/new" class="btn btn-primary">New</router-link>
        </div>
        <table class="table">
            <template>
                <thead>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th colspan="3">Actions</th>
                </thead>
            </template>
            <tbody>
                <template v-if="!offerings.length">
                    <tr>
                        <td colspan="4" class="text-center">No offerings Available</td>
                    </tr>
                </template>
                <template v-else>
                    <tr v-for="(offering,index) in offerings" :key="index">
                        <td>{{ offering.id }}</td>
                        <td>{{ offering.title }}</td>
                        <td>{{ offering.price }}</td>
                        <td>
                            <router-link :to="`/offerings/${offering.id}`">Show</router-link>
                        </td>
                        <td>
                            <router-link :to="`/offerings/${offering.id}/edit`">Edit</router-link>
                        </td>
                        <td>
                             <input type="submit" value="Delete"  @click="deleteOffering(offering.id,index)" class="btn btn-danger"/>
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
            if (this.offerings.length) {
                return;
            }
            this.$store.dispatch('getOfferings');
        },
        computed:{
            offerings(){
                return this.$store.getters.offerings
            },
            currentUser(){
                return this.$store.getters.currentUser;
            }
        },
        methods:{
            deleteOffering(id,index){
                console.log(id);
                axios.delete('/api/offerings/' + id,{
                    headers:{
                        "Authorization":`Bearer ${this.currentUser.token}`,
                    }
                })
                .then(res => {
                    if(this.offerings && this.offerings.length > 0) {
                        this.offerings.splice(index, 1);
                    }
                    this.$store.commit('updateOfferings', res.data.offerings);
                })
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
