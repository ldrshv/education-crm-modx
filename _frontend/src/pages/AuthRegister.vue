<script setup>
    import { ref } from 'vue'
    import axios from 'axios'
    import AuthBase from './AuthBase.vue'
    import AppInputPassword from '../components/AppInputPassword.vue'

    const form = ref({})
    const errors = ref({})
    const success = ref(false)
    const successMessage = ref('')

    const send = function() {
        axios.post('auth/register', form.value)
            .then((response) => {
                errors.value = response.data.data.errors || {}
                success.value = response.data.data.success
                successMessage.value = response.data.data.message || ''
            })
            .catch((error) => {
                console.log(error);
            })
    }
</script>

<template>
    <auth-base title="Создать новый аккаунт" caption="Введите контакные данные для доступа к системе.">
        <q-form @submit="send()" class="q-gutter-md" action="">
            <template v-if="!success">
                <q-input v-model="form.email" outlined name="email" type="email" label="E-mail"
                    :error="!!errors.email || null"
                    :error-message="errors.email"
                />
                <q-input v-model="form.phone" outlined name="phone" type="tel" label="Ваш телефон"/>
                <app-input-password v-model="form.specifiedpassword"
                    :error="!!errors.specifiedpassword || null"
                    :error-message="errors.specifiedpassword"
                />
                <app-input-password v-model="form.confirmpassword"
                    :error="!!errors.confirmpassword || null"
                    :error-message="errors.confirmpassword"
                    label="Подтвердите пароль"
                    name="confirmpassword"
                />

                <p class="text-grey-14">
                    Нажимая на кнопку «зарегистрироваться», вы соглашаетесь с 
                    <a href="#" class="text-primary">Политикой конфиденциальности и защиты персональных данных</a>
                </p>

                <div>
                    <q-btn label="Зарегистрироваться" color="primary" class="full-width" type="submit"/>
                </div>

                <div class="text-center">
                    У вас уже есть аккаунт? <router-link class="text-primary text-weight-medium" to="/auth/login">Войти</router-link>
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