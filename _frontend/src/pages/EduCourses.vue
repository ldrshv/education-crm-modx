<script setup>
    import { ref } from 'vue'
    import { showSuccess, showError, request } from '../functions.js'
    import { store } from '../store.js'
    import BasePage from './BasePage.vue'

    const data = ref([])
    const loading = ref(false)

    request({
        path: `courses`,
        method: 'post',
        data: {
            company_id: store.route.params.company
        },
        loading,
        success(response) {
            data.value = response.data
            console.log(response)
        }
    })
</script>

<template>
    <base-page>
        <div class="box">
            <div class="q-gutter-md">
                <q-card v-for="item in data" class="my-card" flat bordered>
                    <q-card-section horizontal>
                        <q-card-section>
                            <div class="">{{ item.name }}</div>
                        </q-card-section>
                    </q-card-section>
                </q-card>
            </div>
        </div>
    </base-page>
</template>