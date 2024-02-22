<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import AuthBase from './AuthBase.vue'

const route = useRoute()
const router = useRouter()

const error = ref('');
const errorMessage = ref('');

onMounted(async () => {
    await router.isReady()
    error.value = route.query.error || ''

    if (error.value == 'activate-link') {
        errorMessage.value = 'Неверная ссылка для активации аккаунта'
    }

    if (error.value == 'reset-link') {
        errorMessage.value = 'Неверная ссылка для сброса пароля'
    }
})
</script>

<template>
    <auth-base title="Ошибка" :caption="errorMessage">
        <div class="q-gutter-md">
            <div v-if="error == 'reset-link'">
                <router-link class="text-primary text-weight-medium" to="/auth/forgot">Попробовать ещё</router-link>
            </div>
            <div class="">
                <router-link class="text-primary text-weight-medium" to="/auth/login">Войти</router-link>
            </div>
        </div>
    </auth-base>
</template>