import Home from './components/Home.vue';
import Register from './components/Auth/Register.vue';
import Login from './components/Auth/Login.vue';
import OfferingsMain from './components/offerings/Main.vue';
import OfferingsList from './components/offerings/List.vue';
import OfferingNew from './components/offerings/New.vue';
import Offering from './components/offerings/Show.vue';
import OfferingEdit from './components/offerings/Edit.vue';
import PurchasesMain from './components/purchases/Main.vue';
import PurchasesList from './components/purchases/List.vue';
import PurchaseNew from './components/purchases/New.vue';
import Purchase from './components/purchases/Show.vue';
import PurchaseEdit from './components/purchases/Edit.vue';



export const routes = [
{
    path: '/',
    component: Home
},
{
    path: '/register',
    component: Register,
},
{
    path: '/login',
    component: Login,
},
{
    path: '/offerings',
    component: OfferingsMain,
    children:[
        {
            path:'/',
            component:OfferingsList
        },
        {
            path:'new',
            component:OfferingNew
        },
        {
            path:':id',
            component:Offering
        },
        {
            path:':id/edit',
            component:OfferingEdit
        },

    ]
},
    {
        path: '/purchases',
        component: PurchasesMain,
        children:[
            {
                path:'/',
                component:PurchasesList
            },
            {
                path:'new',
                component:PurchaseNew
            },
            {
                path:':id',
                component:Purchase
            },
            {
                path:':id/edit',
                component:PurchaseEdit
            },

        ]
    },
]
