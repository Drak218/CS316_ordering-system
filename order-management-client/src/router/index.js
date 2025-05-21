import { createRouter, createWebHistory } from "vue-router";
import SignIn from '../views/Signin.vue';
import SignUp from '../views/Signup.vue';
import Home from '../views/Home.vue';
import Display from '../views/Display.vue';

const routes = [
    { path: '/', component: SignUp},
    { path: '/signIn', component: SignIn },
    {path: '/home', component: Home},
    {path: '/display', component: Display}
];

export default createRouter({
    history: createWebHistory(),
    routes
});