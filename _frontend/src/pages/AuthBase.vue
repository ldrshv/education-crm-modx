<script setup>
    import axios from 'axios'
    import { useRoute, useRouter } from 'vue-router'

    const props = defineProps(['title', 'caption'])
    const router = useRouter()

    axios.get('user')
        .then((response) => {
            if (response.data.data.success === true) {
                router.push(`/companies`)
            }
        })
        .catch((error) => {
            console.log(error);
        })
</script>

<template>
    <div class="auth-base">
        <div class="row">
            <div class="col-12 col-sm-6 col-md-8 bg-grey-3"></div>
            <div class="auth-base__panel col-12 col-sm-6 col-md-4 shadow-up-8">
                <div class="auth-base__form">
                    <div class="q-mb-xl">
                        <h1 class="q-mb-none text-h6">{{ title }}</h1>
                        <p v-if="caption" v-html="caption" class="q-mt-xs text-grey-14"></p>
                    </div>
                    <slot></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
    .auth-base__panel {
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 2rem;
        min-height: 100vh;
    }

    /* .q-field--with-bottom:not(.q-field--error) {
        padding-bottom: 0 !important;
    } */
</style>