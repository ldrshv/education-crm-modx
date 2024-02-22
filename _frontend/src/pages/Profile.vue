<script setup>
    import { ref, onMounted, watch, watchEffect } from 'vue'
    import { useRoute, useRouter, onBeforeRouteUpdate } from 'vue-router'
    import axios from 'axios'
    import { mdiAccount, mdiTextBoxOutline, mdiFileDocument, mdiEye } from '@quasar/extras/mdi-v6'
    import BasePage from './BasePage.vue'
    import AppInput from '../components/AppInput.vue'
    import AppFilePond from '../components/AppFilePond.vue'
    import { showSuccess, showError, request } from '../functions.js'
    import { store } from '../store.js'

    const route = useRoute()
    const router = useRouter()

    const loading = ref(false)
    const formEl = ref(null)
    const form = ref({ description: '' })
    const formChanged = ref(false)
    const passwordForm = ref({})
    const passwordFormErrors = ref({})
    const files = ref({})
    const avatarPond = ref(null)
    const tab = ref('edit')
    const nextTab = ref(null)

    const save = function() {
        form.value.avatar = avatarPond.value.getFiles()

        request({
            method: 'post',
            path: `profile/update`,
            data: form.value,
            hasFiles: true,
            loading,
            successMessage: 'Профиль обновлён',
            success(response) {
                getProfile()
            },
            finally() {
                formChanged.value = false
            },
        })
    }

    const changePassword = function() {
        loading.value = true;

        axios.post(`profile/change_password`, passwordForm.value)
            .then((response) => {
                passwordFormErrors.value = response.data?.data?.errors || {}
                if (response.data?.data?.success) {
                    showSuccess('Пароль изменён')
                }
            })
            .catch((error) => showError(error))
            .finally(() => loading.value = false)
    }

    const getProfile = function() {
        request({
            path: `profile`,
            loading,
            success(response) {
                form.value = response
                form.value.change_password = false
                files.value.avatar = response.photo ? [response.photo] : []
                store.profile.avatar = response.photo
                // files.value.portfolio = response.data.data.data.portfolio || []
                // files.value.resume = response.data.data.data.resume || []
                // passwordForm.value.username = form.value.email
            },
        })
    }

    const fields = [
        { field: 'surname', label: 'Фамилия', validate: ['required'] },
        { field: 'fullname', label: 'Имя', validate: ['required'] },
        { field: 'middlename', label: 'Отчество' },
        { field: 'birthdate', label: 'Дата рождения', type: 'date' },
        { field: 'country', label: 'Страна' },
        { field: 'city', label: 'Город' },
    ]

    const contactFields = [
        { field: 'phone', label: 'Телефон', validate: ['phone'] },
        { field: 'tg', label: 'Профиль в Телеграм' },
        { field: 'vk', label: 'Профиль в ВК' },
    ]

    const passwordFields = [
        { field: 'old_password', type: 'password', label: 'Старый пароль' },
        { field: 'new_password', type: 'password', label: 'Новый пароль' },
        { field: 'confirm_password', type: 'password', label: 'Подтвердите пароль', validate: ['confirm_password'] },
    ]

    getProfile()
</script>

<template>
    <base-page>
        <template v-slot:actions>
            <div class="row">
                <q-btn class="q-mr-md" flat :loading="loading"/>
                <q-btn @click="formEl.submit()" label="Сохранить" color="positive"/>
            </div>
        </template>

        <q-form class="main" @submit="save" ref="formEl">
            <div class="main__sidebar">
                <div class="box">
                    <app-file-pond :files="files.avatar" ref="avatarPond" label="Загрузить аватар" :avatar="true"/>
                </div>
                <div class="box">
                    <div class="q-gutter-lg q-mt-none">
                        <label class="checkbox-title">
                            <q-checkbox v-model="form.change_password" val="true" label="Изменить пароль" class="text-h6"/>
                        </label>
                        <template v-if="form.change_password">
                            <template v-for="i in passwordFields">
                                <div class="">
                                    <input type="text" name="password" hidden>
                                    <app-input v-model="passwordForm[i.field]" :opts="i"
                                        @update:model-value="passwordFormErrors[i.field] = ''"
                                        :error="passwordFormErrors[i.field]"
                                        :form="passwordForm"
                                        autocomplete="new-password"
                                    />
                                </div>
                            </template>
                        </template>
                    </div>
                </div>
            </div>

            <div class="">
                <div class="box">
                    <h2 class="text-h6">Личные данные</h2>
                    <div class="row q-col-gutter-lg">
                        <template v-for="i, n in fields">
                            <div :class="n < 3 ? 'col-md-4' : 'col-md-6'" class="col-12">
                                <app-input v-model="form[i.field]" :opts="i" @update:model-value="formChanged = true"/>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="box">
                    <h2 class="text-h6">Контактные данные</h2>
                    <div class="row q-col-gutter-lg">
                        <template v-for="i in contactFields">
                            <div class="col-12 col-md-6">
                                <app-input v-model="form[i.field]" :opts="i" @update:model-value="formChanged = true"/>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="box">
                    <h2 class="text-h6">О себе</h2>
                    <q-editor v-model="form.description" @update:model-value="formChanged = true" min-height="5rem"/>
                </div>
            </div>
        </q-form>
    </base-page>
</template>