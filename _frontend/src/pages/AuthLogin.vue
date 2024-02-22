<script setup>
    import { ref } from 'vue'
    import axios from 'axios'
    import { useRoute, useRouter } from 'vue-router'
    import AuthBase from './AuthBase.vue'
    import AppInputPassword from '../components/AppInputPassword.vue'

    const router = useRouter()

    const form = ref({})
    const errorMessage = ref('')
    const showPwd = ref(false)

    const auth = function() {
        axios.post('auth/login', form.value)
            .then((response) => {
                console.log(response.data.data);
                if (response.data.data.success === true) {
                    router.push(`/account`)
                } else {
                    errorMessage.value = response.data.data.message || ''
                }
            })
            .catch((error) => {
                console.log(error);
            })
    }
</script>

<template>
    <auth-base title="Авторизация" caption="Введите e-mail и пароль для доступа к системе">
        <form @submit.prevent="auth()" class="q-gutter-md" action="">
            <q-input v-model="form.username" outlined name="email" type="email" label="Email"/>
            <app-input-password v-model="form.password"/>

            <q-banner v-if="errorMessage" class="text-white bg-negative">
                {{ errorMessage }}
            </q-banner>

            <div>
                <q-btn label="Войти" color="primary" class="full-width" type="submit"/>
            </div>

            
            <div class="text-center">
                <router-link class="text-primary text-weight-medium" to="/auth/forgot">Забыли пароль?</router-link>
            </div>
            <div class="text-center">
                Нет аккаунта? <router-link class="text-primary text-weight-medium" to="/auth/register">Зарегистрироваться</router-link>
            </div>
        </form>
    </auth-base>
</template>