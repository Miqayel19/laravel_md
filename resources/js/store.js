import {getLoggedinUser} from './auth'

const user = getLoggedinUser();
export default {
    state:{
        welcome:"Welcome to my App",
        currentUser:user,
        auth_error:null,
        isLogged:!!user,
        registeredUser: null,
        reg_error:null,
        offerings:[],
        purchases:[],
    },
    getters:{
        welcome(state){
            return state.welcome;
        },
        currentUser(state){
            return state.currentUser
        },
        authError(state){
            return state.auth_error
        },
        isLogged(state){
            return state.isLogged
        },
        regError(state){
            return state.reg_error;
        },
        registeredUser(state){
            return state.registeredUser;
        },
        offerings(state){
            return state.offerings
        },
        purchases(state){
            return state.purchases
        },

    },
    mutations:{
        login(state) {
            state.auth_error = null;
        },

        loginSuccess(state,payload){
            state.isLogged = true
            state.auth_error = null
            state.currentUser = Object.assign({},payload.user,{token:payload.token})
            localStorage.setItem('user',JSON.stringify(state.currentUser))
        },
        loginFailed(state,payload){
            state.isLogged = false
            state.auth_error = payload.error
        },
        regFailed(state,payload){
            state.reg_error = payload.error
        },
        regSuccess(state,payload){
            state.reg_error = null
            state.registeredUser = payload.user;
        },
        logout(state){
            state.isLogged = false
            localStorage.removeItem('user')
            state.currentUser = null
        },
        updateOfferings(state,payload){
            state.offerings = payload
        },
        updatePurchases(state,payload){
            state.purchases = payload
        }
    },
    actions:{
        login(context){
            context.commit('login')
        },
        getOfferings(context){
            axios.get('/api/offerings',{
                headers:{
                    'Authorization':`Bearer ${context.state.currentUser.token}`
                }
            })
            .then((response) => {
                context.commit('updateOfferings', response.data.offerings);
            })
        },
        getPurchases(context){
            axios.get('/api/purchases',{
                headers:{
                    'Authorization':`Bearer ${context.state.currentUser.token}`
                }
            })
            .then((response) => {
                context.commit('updatePurchases', response.data.purchases);
            })
        }
    }
};
