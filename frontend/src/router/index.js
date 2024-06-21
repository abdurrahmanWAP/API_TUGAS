import Vue from "vue";
import VueRouter from "vue-router";
import HomeView from "../views/HomeView.vue";
import FoodList from "../views/Foods.vue";
import FoodDetails from "../views/FoodDetails.vue";
import Keranjang from "../views/Keranjang.vue";
import PesananSukses from "../views/PesananSukses.vue";
import CreateFoods from "../views/CreateFoods.vue";
import PesananList from "../views/PesananList.vue";
import DetailsFoods from "../views/DetailsFoods.vue";

Vue.use(VueRouter);

const routes = [
    {
        path: "/",
        name: "home",
        component: HomeView,
    },
    {
        path: "/foods",
        name: "FoodList",
        component: FoodList,
    },
    {
        path: "/foods/:id_product",
        name: "FoodDetails",
        component: FoodDetails,
    },
    {
        path: "/keranjang",
        name: "Keranjang",
        component: Keranjang,
    },
    {
        path: "/pesanan-sukses",
        name: "PesananSukses",
        component: PesananSukses,
    },
    {
        path: "/create-foods",
        name: "CreateFoods",
        component: CreateFoods,
    },
    {
        path: "/pesanans",
        name: "PesananList",
        component: PesananList,
    },
    {
        path: "/detail-food/:id_product",
        name: "DetailsFoods",
        component: DetailsFoods,
    },
    {
        path: "/about",
        name: "about",
        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: () =>
            import(/* webpackChunkName: "about" */ "../views/AboutView.vue"),
    },
];

const router = new VueRouter({
    mode: "history",
    base: process.env.BASE_URL,
    routes,
});

export default router;
