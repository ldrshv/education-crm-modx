<script setup>
    import { ref } from 'vue'
    import axios from 'axios'
    import AuthBase from './AuthBase.vue'

    const form = ref({})
    const error = ref('')
    const success = ref(false)
    const successMessage = ref('')

    const submit = function() {
        axios.post('auth/forgot', form.value)
            .then((response) => {
                if (response.data.data.success) {
                    success.value = true
                    successMessage.value = response.data.data.message || ''
                } else {
                    error.value = response.data.data.message || ''
                }
            })
            .catch((error) => {
                console.log(error);
            })
    }
</script>

<template>
    <auth-base
        title="Сбросить пароль"
        caption="Введите адрес электронной почты, указанной при регистрации.<br>Мы вышлем вам инструкцию для восстановления доступа к сервису."
    >
        <q-form @submit="submit" class="q-gutter-md" action="">
            <template v-if="!success">
                <q-input v-model="form.email" outlined name="email" type="email" label="Ваш e-mail"
                    :error="!!error || null" :error-message="error"
                />

                <div>
                    <q-btn label="Отправить" color="primary" class="full-width" type="submit"/>
                </div>

                <div class="text-center">
                    Вернуться к <router-link class="text-primary text-weight-medium" to="/auth/login">авторизации</router-link>
                </div>
            </template>

            <template v-else>
                <p class="text-body1">{{ successMessage }}</p>

                <!-- <div class="text-center">
                    <q-btn label="Войти" to="/auth/login" color="primary" class="full-width"/>
                </div> -->
            </template>
        </q-form>
    </auth-base>
</template>