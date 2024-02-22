import './style.scss'
import { createApp, ref } from 'vue';
import { createRouter, createWebHashHistory } from 'vue-router'

import { Quasar, Notify, AppFullscreen, Dialog, Dark, setCssVar } from 'quasar'
import langRu from 'quasar/lang/ru'
import quasarIconSet from 'quasar/icon-set/svg-mdi-v7'
import 'quasar/dist/quasar.css'


import axios from 'axios'
axios.defaults.withCredentials = true;
axios.defaults.headers.post['Content-Type'] = 'application/json';
axios.defaults.baseURL = import.meta.env.VITE_API_URL + 'api';

import App from './App.vue'
import AuthLogin from './pages/AuthLogin.vue'
import AuthRegister from './pages/AuthRegister.vue'
import AuthForgot from './pages/AuthForgot.vue'
import AuthError from './pages/AuthError.vue'

import { store } from './store.js'



const routes = [
    { path: '/', redirect: '/auth/login' },
    { path: '/auth/login', component: AuthLogin, meta: { title: 'Вход' } },
    { path: '/auth/register', component: AuthRegister, meta: { title: 'Регистрация' } },
    { path: '/auth/forgot', component: AuthForgot, meta: { title: 'Забыли пароль?' } },
    { path: '/auth/error', component: AuthError, meta: { title: 'Ошибка' } },

    {
        path: '/profile',
        component: () => import('./pages/Profile.vue'),
        meta: { title: 'Мой профиль' }
    },

    {
        path: '/companies',
        component: () => import('./pages/Companies.vue'),
        meta: { title: 'Мои организации' }
    },
    {
        path: '/company/new',
        component: () => import('./pages/CompanyNew.vue'),
        meta: { title: 'Добавить организацию' }
    },
    {
        path: '/company/:id(\\d+)',
        component: () => import('./pages/CompanyEdit.vue'),
        meta: { title: 'Огранизация' }
    },
    
    // { path: '/company/:company(\\d+)/courses', component: EduCourses, meta: { title: 'Курсы' } },
    // { path: '/company/:company(\\d+)/course/new', component: EduCourseEdit, meta: { title: 'Создать курс' } },
    // { path: '/company/:company(\\d+)/course/:id(\\d+)/edit', component: EduCourseEdit, meta: { title: 'Редактировать курс' } },
]

const router = createRouter({
    history: createWebHashHistory(),
    routes,
})

router.beforeEach((to, from, next) => {
    store.route = to
    if (to.meta.title) {
        document.title = to.meta.title + ' | Education CRM'
    }
    next()
})


const app = createApp(App);
app.use(router);
app.use(Quasar, {
    lang: langRu,
    plugins: {
        Notify,
        AppFullscreen,
        Dialog
    },
    config: {
        brand: {
            primary: '#038edc',
            //secondary: '#25c2e3',
            //positive: '#43d39e',
            negative: '#f34e4e',
            //dark: '#4B4B5A',
            light: '#ccc',
        },
        notify: {}
    },
    iconSet: quasarIconSet,
})
app.mount('#app');