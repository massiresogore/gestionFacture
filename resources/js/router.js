import Home from "./component/Home.vue";
import InvoiceHome from "./component/invoice/InvoiceHome.vue";
import NotFound from "./component/NotFound.vue";
import {createRouter, createWebHistory} from "vue-router";


const routes = [
    {
        path: "/",
        component: Home
    },
    {
      path: "/:pathMatch(.*)*",
      component: NotFound
    },
    {
        path: "/invoice",
        component: InvoiceHome
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
