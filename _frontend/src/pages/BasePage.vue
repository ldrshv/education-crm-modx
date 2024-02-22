<script setup>
import { ref, onMounted, computed, reactive } from 'vue'
import axios from 'axios'
import { useRoute, useRouter } from 'vue-router'
import {
    mdiMenuDown, mdiMenu,
    mdiFullscreen, mdiFullscreenExit,
    mdiAccountOutline, mdiAccountDetails, mdiExitToApp,
    mdiChevronRight, mdiChevronDown,
    mdiWhiteBalanceSunny, mdiWeatherNight
} from '@quasar/extras/mdi-v6'
import { useQuasar, Dark } from 'quasar'
import { showSuccess, showError } from '../functions.js'
import { store } from '../store.js'

const $q = useQuasar()
const route = useRoute()
const router = useRouter()
const loading = ref(true)
const user = ref({})
const year = new Date().getFullYear()

const title = computed(() => {
    return store.route.meta.title || ''
})

const logout = function () {
    axios.get('auth/logout')
        .then((response) => {
            delete store.profile.username
            if (response.data.data.success === true) {
                router.push(`/auth/login`)
            }
        })
        .catch((error) => {
            showError(error)
            delete sessionStorage.user
        })
}


if (!store.profile.username) {
    axios.get('user')
        .then((response) => {
            if (response.data.data.success === true) {
                store.profile.avatar = response.data.data.data.photo;
                store.profile.username = response.data.data.data.email;
            } else {
                router.push(`/auth/login`)
            }
        })
        .catch((error) => {
            showError(error)
            router.push(`/auth/login`)
        })
        .finally(() => {
            loading.value = false
        })
}


const leftDrawerOpen = ref(false)
function toggleLeftDrawer () {
    leftDrawerOpen.value = !leftDrawerOpen.value
}

const menu = [
    {
        label: 'Организации',
        icon: mdiAccountDetails,
        to: '/companies',
    },
    {
        label: 'Обучение сотрудников',
        icon: mdiAccountDetails,
    },
    {
        icon: mdiAccountDetails,
        to: '/profile',
        label: 'Мой профиль',
    },
]


const darkSet = function(value) {
    localStorage.setItem("darkTheme", value);
    Dark.set(value);
}

Dark.set(localStorage.getItem("darkTheme") == 'true' ? true : false)
</script>

<template>
    <q-layout view="hHh LpR fff">
        <q-header class="bg-dark" bordered>
            <q-toolbar>
                <q-btn flat dense round @click="toggleLeftDrawer" :icon="mdiMenu" size="16px"/>
                <q-toolbar-title>Education CRM</q-toolbar-title>

                <q-btn
                    @click="darkSet(!Dark.isActive)"
                    :icon="Dark.isActive ? mdiWhiteBalanceSunny : mdiWeatherNight"
                    flat dense
                />

                <q-btn-dropdown stretch flat :dropdown-icon="mdiChevronDown" class="q-ml-sm text-lowercase">
                    <template v-slot:label>
                        <div class="row items-center no-wrap q-gutter-x-sm">
                            <q-avatar size="32px" color="white" text-color="primary">
                                <img v-if="store.profile.avatar" :src="store.profile.avatar" alt="">
                                <span v-else>{{ store.profile.username && store.profile.username[0] }}</span>
                            </q-avatar>
                            <div>{{ store.profile.username }}</div>
                        </div>
                    </template>
                    <q-list>
                        <q-item to="profile">
                            <q-item-section avatar>
                                <q-icon :name="mdiAccountOutline" size="16px" />
                            </q-item-section>
                            <q-item-section>
                                <q-item-label>Мой профиль</q-item-label>
                            </q-item-section>
                        </q-item>
                        <q-item clickable class="text-negative">
                            <q-item-section avatar>
                                <q-icon :name="mdiExitToApp" size="16px" />
                            </q-item-section>
                            <q-item-section @click="logout">
                                <q-item-label>Выход</q-item-label>
                            </q-item-section>
                        </q-item>
                    </q-list>
                </q-btn-dropdown>
            </q-toolbar>
        </q-header>
        
        <q-drawer v-model="leftDrawerOpen" show-if-above :width="250" bordered>
            <div class="" v-for="item in menu">
                <q-list>
                    <q-item 
                        :icon="item.icon"
                        :to="item.to"
                    >
                        <q-item-section>
                            <q-item-label>{{ item.label }}</q-item-label>
                        </q-item-section>
                    </q-item>
                    <q-separator/>
                </q-list>

            </div>
        </q-drawer>

        <q-page-container>
            <q-page class="">
                <slot></slot>
            </q-page>
        </q-page-container>

        <q-footer class="bg-dark" bordered>
            <div class="row justify-between q-py-md q-px-lg">
                <div class="">{{ year }} © HRPLUS.</div>
                <div class="">сделано в <a href="#" class="text-primary">ТОЧКА РОСТА МАРКЕТИНГ</a></div>
            </div>
        </q-footer>

        <q-page-sticky expand position="top" class="bg-default">
            <q-toolbar class="q-py-md q-px-lg">
                <q-toolbar-title><h1 class="q-ma-none text-h5">{{ title }}</h1></q-toolbar-title>
                <slot name="actions"></slot>
            </q-toolbar>
        </q-page-sticky>
    </q-layout>
</template>


<style lang="scss">
// .q-page-container {
//     min-height: 100vh;
//     background-color: #f4f8f9;
// }

// .q-toolbar {
//     padding: 0 1.5rem 0 1rem;

//     .q-btn-dropdown {
//         padding-top: 18px;
//         padding-bottom: 18px;
//     }

//     .q-btn-dropdown--simple * + .q-btn-dropdown__arrow {
//         font-size: 16px;
//     }

//     .q-toolbar__title {
//         @media (max-width: 575px) {
//             font-size: 0;
//         }
//     }
// }

// .q-item__section--avatar {
//     min-width: 0;
// }

// .acc-subheader {
//     padding: 0.5rem 1.5rem 2rem;

//     @media (min-width: 1024px) {
//         padding: 1.5rem 1.5rem 6.5rem;
//     }

//     h1 {
//         margin: 0;
//     }
// }

// .acc-main {
//     position: relative;
//     margin: 0 1.5rem 0;
//     padding-bottom: 60px;

//     @media (min-width: 1024px) {
//         margin: -45px 1.5rem 0;
//     }
// }

// .box {
//     position: relative;
//     padding: 1.25rem;
//     background-color: #fff;
//     border-radius: 0.5rem;
//     box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.03);

//     h2:first-child {
//         margin-top: 0;
//     }
// }
</style>