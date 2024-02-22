<script setup>
    import { ref, computed, onMounted, watch, watchEffect } from 'vue'
    import axios from 'axios'
    import BasePage from './BasePage.vue'
    import AppInput from '../components/AppInput.vue'
    import { showSuccess, showError, request } from '../functions.js'
    import { store } from '../store.js'

    const loading = ref(false)
    const formEl = ref(null)
    const form = ref({
        description: '',
    })
    const mode = ref('new')

    const send = function() {
        form.value.company_id = store.route.params.company

        request({
            method: 'post',
            path: 'course/new',
            data: form.value,
            loading,
            successMessage: 'Курс создан',
            success(response) {
                console.log(response)
            }
        })
    }

    watchEffect(() => {
        if (!store.route.path.includes('/course/')) {
            return
        }
        
        mode.value = store.route.path.includes('/new') ? 'new' : 'edit'

        if (mode.value === 'edit') {
            request({
                path: `course/${store.route.params.id}`,
                loading,
                success(response) {
                    form.value = response.data
                    console.log(response)
                }
            })
        }

        if (mode.value === 'new') {
            form.value = { description: '' }
        }
    });
</script>

<template>
    <base-page>
        <q-form  @submit="send()" ref="formEl" greedy class="box" action="">
            <q-inner-loading :showing="loading" color="primary"/>

            {{ mode }}

            <div class="q-col-gutter-lg">
                <div class="col-12">
                    <app-input v-model="form.name" :opts="{ label: 'Название курса', validate: ['required'] }"/>
                </div>
                <div class="col-12">
                    <p class="q-mb-sm">Описание курса</p>
                    <q-editor v-model="form.description" min-height="5rem" />
                </div>
                <div class="col-12">
                    <q-btn type="submit" label="Сохранить" color="primary"/>
                </div>
            </div>
        </q-form>
    </base-page>
</template>