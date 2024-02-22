<script setup>
    import { ref, onMounted, watch, watchEffect } from 'vue'
    import { useRoute, useRouter, onBeforeRouteUpdate } from 'vue-router'
    import axios from 'axios'
    import { mdiAccount, mdiTextBoxOutline, mdiFileDocument, mdiEye } from '@quasar/extras/mdi-v6'
    import BasePage from './BasePage.vue'
    import AppInput from '../components/AppInput.vue'
    import AppFilePond from '../components/AppFilePond.vue'
    import { showSuccess, showError } from '../functions.js'

    const props = defineProps({
        createNew: {},
    })

    const route = useRoute()
    const router = useRouter()

    const loading = ref(false)
    const formEl = ref(null)
    const form = ref({
        description: ''
    })
    const formChanged = ref(false)
    const id = ref(0)
    const myFiles = ref([])
    const pond = ref(null)
    const tab = ref('edit')

    const editCompany = function() {
        loading.value = true;

        const headers = {}
        headers['Content-Type'] = "multipart/form-data"

        let data = { id: id.value }
        data = form.value

        if (pond.value.getFile) {
            data.logo = pond.value.getFile()
        }

        axios.post(`company/update`, data, { headers })
            .then((response) => {
                if (response.data?.data?.success) {
                    getCompany()
                    showSuccess('Данные сохранены')
                    formChanged.value = false
                } else {
                    showError()
                }
            })
            .catch((error) => showError(error))
            .finally(() => loading.value = false)
    }

    const newCompany = function() {
        loading.value = true;
        
        axios.post(`company/new`, form.value)
            .then((response) => {
                if (response.data?.data?.success) {
                    showSuccess('Организация создана')
                    router.push(`/company/${response.data.data.data.id}`)
                } else {
                    showError()
                }
            })
            .catch((error) => showError(error))
            .finally(() => loading.value = false)
    }

    const save = function() {
        props.createNew ? newCompany() : editCompany()
    }

    const getCompany = function() {
        loading.value = true;

        axios.get(`company/${id.value}`)
            .then((response) => {
                if (response.data.data.success) {
                    form.value = response.data.data.data
                    form.value.description = form.value.description || ''
                    myFiles.value = response.data.data.data.logo
                        ? [response.data.data.data.logo.replace('http://127.0.0.1/assets/files/', '/files/')]
                        : []
                    loading.value = false;
                } else {
                    showError('компания не найдена')
                }
            })
            .catch((error) => showError(error))
            .finally(() => loading.value = false)
    }

    onMounted(async () => {
        await router.isReady()
        id.value = +route.params.id || 0
        props.createNew || getCompany()
        tab.value = route.query.tab || 'edit'
    })

    onBeforeRouteUpdate(async (to, from) => {
        console.log(to)
        if (!props.createNew && to.params.id !== from.params.id) {
            id.value = +to.params.id
            getCompany()
        }
    })

    const fields = [
        { field: 'name', name: 'company_name', label: 'Наименование', validate: ['required'] },
        // { field: 'brand', label: 'Бренд' },
        { field: 'address', label: 'Адрес' },
        { field: 'phone', label: 'Телефон', type: 'tel' },
        { field: 'site', label: 'Сайт организации' },
        { field: 'email', label: 'E-mail', type: 'email' },
        // { field: 'inn', label: 'ИНН', type: 'number' },
        // { field: 'ogrn', label: 'ОГРН', type: 'number' }
    ]
</script>

<template>
    <base-page>
        <template v-slot:actions>
            <q-btn @click="formEl.submit()" label="Сохранить" color="positive"/>
        </template>

        <q-form class="row q-col-gutter-lg" @submit="save" ref="formEl">
            <q-inner-loading :showing="loading" color="primary"/>

            <div class="col-4">
                <!-- Лого -->
                <div @submit="save" class="box " action="">
                    <app-file-pond :files="myFiles" ref="pond" label="Загрузить логотип"

                    
                    />
                </div>
            </div>

            <!--  -->
            <div class="col-8">
                <div class="box">
                    <h2 class="text-h6">Данные организации</h2>

                    <div class="row q-col-gutter-lg">
                        <template v-for="i in fields">
                            <div class="col-12 col col-md-6">
                                <app-input v-model="form[i.field]" :opts="i" @update:model-value="formChanged = true"/>
                            </div>
                        </template>
                        <!-- <div class="col-12">
                            <q-btn label="Сохранить" type="submit" color="primary"/>
                        </div> -->
                    </div>
                    <p class="q-mt-lg q-mb-sm">Описание</p>
                    <q-editor v-model="form.description" @update:model-value="formChanged = true" min-height="5rem" />

                    <q-btn label="Сохранить" color="positive"/>
                </div>

                <!-- Лого -->
                <!-- <q-form v-if="tab == 'logo'" @submit="submit" ref="formEl" class="box "  action="">
                    <h2 class="text-h6">Загрузить логотип организации:</h2>
                    <app-file-pond :files="myFiles" ref="pond" label="загрузить логотип"/>
                </q-form> -->

                <!-- Просмотр  -->
                <!-- <div v-if="tab == 'view'" class="box">
                    <div v-if="form.logo">
                        <img width="160" :src="form.logo" alt="">
                    </div>

                    <h2 class="text-h6">Общие данные:</h2>
                    <template v-for="i in fields">
                        <p class="">
                            <b>{{ i.label }}:</b> {{ form[i.field] || '—' }} 
                        </p>
                    </template>
                    <p><b>Описание организации:</b><div v-html="form.description"></div></p>

                    <h2 class="q-mt-lg text-h6">Группы в соцсетях и каналы в мессенджерах:</h2>
                    <template v-for="i in contactsFields">
                        <p v-if="i.field.startsWith('group_')" class="">
                            <b>{{ i.label }}:</b> {{ contactForm[i.field] || '—' }} 
                        </p>
                    </template>

                    <h2 class="q-mt-lg text-h6">Мессенджеры:</h2>
                    <template v-for="i in contactsFields">
                        <p v-if="i.field.startsWith('msg_')" class="">
                            <b>{{ i.label }}:</b> {{ contactForm[i.field] || '—' }} 
                        </p>
                    </template>
                </div> -->

                <!--  -->
                <!-- <div class="row justify-between q-mt-lg">
                    <template v-if="tab == 'edit'">
                        <q-btn label="Назад" color="dark" disabled/>
                        <q-btn @click="changeTab('contacts')" label="Вперёд" color="primary"/>
                    </template>
                    <template v-else-if="tab == 'contacts'">
                        <q-btn @click="changeTab('edit')" label="Назад" color="dark"/>
                        <q-btn @click="changeTab('logo')" label="Вперёд" color="primary"/>
                    </template>
                    <template v-else-if="tab == 'logo'">
                        <q-btn @click="changeTab('contacts')" label="Назад" color="dark"/>
                        <q-btn @click="changeTab('view')" label="Вперёд" color="primary"/>
                    </template>
                    <template v-else-if="tab == 'view'">
                        <q-btn @click="changeTab('logo')" label="Назад" color="dark"/>
                        <q-btn to="/account/companies" label="Финиш" color="positive"/>
                    </template>
                </div> -->
            </div>
        </q-form>
    </base-page>
</template>