<script setup>
import { ref, computed, onMounted, watch } from 'vue'
import axios from 'axios'
import { useRoute, useRouter } from 'vue-router'
import { mdiDotsHorizontal, mdiClose, mdiPencil, mdiEye, mdiPlusCircleOutline, mdiMinusCircleOutline, mdiPackageUp, mdiPackageDown } from '@quasar/extras/mdi-v6'
import BasePage from './BasePage.vue'
import AppTooltip from '../components/AppTooltip.vue'
import AppTableValue from '../components/AppTableValue.vue'
import { useElementSize } from '@vueuse/core'
import { useQuasar } from 'quasar'
import { showSuccess, showError } from '../functions.js'
import { store } from '../store.js'

const loading = ref(true)
const hiddenColumns = ref([])
const rows = ref([])
const filter = ref({ status: '' })
const box = ref(null)
const { width } = useElementSize(box)
const $q = useQuasar()
const route = useRoute()
const router = useRouter()

const tableColumns = computed(() => {
    console.log(store.route.path)
    // if (store.route.path.includes('/hr/')) {
    //     return [
    //         { name: 'name', label: 'Наименование организации', field: 'name', align: 'left', sortable: true},
    //         { name: 'inn', label: 'ИНН', field: 'inn', align: 'left', hideFrom: 1200, sortable: false },
    //         { name: 'vacancy_count', label: 'Вакансии', field: 'vacancy_count', align: 'center', hideFrom: 900, sortable: false },
    //         { name: 'users', label: 'Пользователи', field: 'users', align: 'center', hideFrom: 900, sortable: false },
    //         { name: 'feedback', label: 'Отклики в работе', field: 'feedback', align: 'center', hideFrom: 900, sortable: false },
    //         { name: 'author', label: 'Создатель аккаунта', field: 'author', align: 'left', hideFrom: 1050, sortable: false },
    //         { name: 'createdon', label: 'Дата создания', field: 'createdon', align: 'left', hideFrom: 1300, sortable: false },
    //         { name: 'action', label: 'Действие', field: 'action', hideFrom: 400, sortable: false },
    //     ]
    // }

    // if (store.route.path.includes('/edu/')) {
        return [
            { name: 'name', label: 'Наименование организации', field: 'name', align: 'left', sortable: true},
            { name: 'inn', label: 'ИНН', field: 'inn', align: 'left', hideFrom: 1200, sortable: false },
            { name: 'courses_count', label: 'Курсы', field: 'courses_count', align: 'center', hideFrom: 900, sortable: false },
            { name: 'author', label: 'Создатель аккаунта', field: 'author', align: 'left', hideFrom: 1050, sortable: false },
            { name: 'createdon', label: 'Дата создания', field: 'createdon', align: 'left', hideFrom: 1300, sortable: false },
            { name: 'action', label: 'Действие', field: 'action', hideFrom: 0, sortable: false },
        ]
    // }
    
    return []
})

const visibleColumns = computed(() => {
    const visible = []
    hiddenColumns.value = []

    for (const col in tableColumns.value) {
        if ((tableColumns.value[col].hideFrom || 0) < width.value) {
            visible.push(tableColumns.value[col].name)
        } else {
            hiddenColumns.value.push(tableColumns.value[col].name)
        }
    }

    return visible
})

const getList = function(name) {
    loading.value = true
    
    axios.post('company/list', { status: filter.value.status })
        .then((response) => {
            rows.value = response.data.data.data
            console.log(response.data.data.data)
        })
        .catch((error) => showError(error))
        .finally(() => loading.value = false)
}

const findColumn = function(name) {
    return tableColumns.value.find(el => el.name === name);
}

const removeCompany = function(id, name) {
    $q.dialog({
        title: `Удалить компанию «${name}»?`,
        cancel: 'Отмена',
        persistent: true
    }).onOk(() => {
        axios.post('company/delete', { id })
            .then((response) => {
                console.log(response.data)
                if (response.data.data.success) {
                    getList()
                    showSuccess('Компания удалена')
                } else {
                    showError(response.data.data.message)
                }
            })
            .catch((error) => showError(error))
    })
}

const changeStatus = function(id, name, status) {
    $q.dialog({
        title: `${status == 'archived' ? 'Добавить в архив' : 'Восстановить'} компанию «${name || 'Без названия'}»?`,
        cancel: 'Отмена',
        persistent: true
    }).onOk(() => {
        axios.post('company/update', { id, status })
            .then((response) => {
                if (response.data.data.success) {
                    getList()
                    showSuccess(`Компания ${status == 'archived' ? 'в архиве' : 'восстановлена'}`)
                } else {
                    showError(response.data.data.message)
                }
            })
            .catch((error) => showError(error))
    })
}

const createVacancy = function(id) {
    loading.value = true
    
    axios.post('/hr/vacancy/new', { 'company_id': id })
        .then((response) => {
            if (response.data?.data?.success) {
                console.log(response.data.data)
                router.push(`/hr/vacancy/${response.data.data.data.id}/edit`)
            } else {
                showError(response.data?.data?.message)
            }
        })
        .catch((error) => showError(error))
        .finally(() => loading.value = false)
}

onMounted(() => {
    getList()
})
</script>

<template>
    <base-page>
        <q-inner-loading :showing="loading" color="primary"/>

        <div class="box" ref="box">
            {{ state }}
            <div class="row justify-between q-mb-md" >
                <q-select
                    v-model="filter.status"
                    @update:model-value="getList()"
                    :options="[{ label: 'Не в архиве', value: '' }, { label: 'Показать все', value: 'all' }]"
                    emit-value
                    map-options
                    outlined
                    class="col-12 col-sm-auto"
                />
            </div>

            <div v-if="!rows.length && !loading">
                Нет организаций
            </div>

            <q-table
                v-else
                :rows="rows" row-key="id" 
                :columns="tableColumns" :visible-columns="visibleColumns"
                binary-state-sort
                :rows-per-page-options="[0]" hide-bottom
                flat
                class="comp-table"
            >
                <!-- шапка -->
                <template v-slot:header="props">
                    <q-tr :props="props">
                        <q-th auto-width />
                        <q-th v-for="col in props.cols" :key="col.name" :props="props">
                            {{ col.label }}
                        </q-th>
                    </q-tr>
                </template>

                <template v-slot:body="props">
                    <q-tr :props="props">
                        <!-- кнопка + -->
                        <q-td auto-width>
                            <q-btn v-if="hiddenColumns.length && !props.expand"
                                @click="props.expand = !props.expand" round flat class="comp-table__expand-btn">
                                <q-icon :name="mdiPlusCircleOutline" size="22px" color="positive"/>
                            </q-btn>
                            <q-btn v-if="hiddenColumns.length && props.expand"
                                @click="props.expand = !props.expand" round flat class="comp-table__expand-btn">
                                <q-icon :name="mdiMinusCircleOutline" size="22px" color="negative"/>
                            </q-btn>
                        </q-td>
                        <!-- Ячейка -->
                        <q-td v-for="col in props.cols" :key="col.name" :props="props">
                            <template v-if="col.name === 'name'">
                                <router-link :to="`/company/${props.row.id}`"
                                    :class="props.row.status == 'archived' ? 'text-grey' : 'text-primary'">
                                    <b>{{ props.row.name }}</b>
                                    <app-tooltip>Вся информация об организации</app-tooltip>
                                </router-link>
                            </template>

                            <template v-else-if="col.name === 'courses_count'">
                                <router-link v-if="props.row.courses_count" :to="`/hr/company/${props.row.id}/vacancies`">
                                    <q-badge color="positive">
                                        {{ props.row.courses_count }}
                                        <app-tooltip class="bg-dark">Посмотреть все курсы организации</app-tooltip>
                                    </q-badge>
                                </router-link>

                                <q-badge v-else @click="createVacancy(props.row.id)" color="negative" class="cursor-pointer">
                                    {{ props.row.courses_count }}
                                    <app-tooltip class="bg-dark">Создать курс</app-tooltip>
                                </q-badge>
                            </template>
<!-- 
                            <template v-else-if="col.name === 'users'">
                                <q-badge color="negative">0<app-tooltip class="bg-dark">Пригласить специалиста в организацию</app-tooltip></q-badge>
                            </template>

                            <template v-else-if="col.name === 'feedback'">
                                <q-badge color="negative">0<app-tooltip class="bg-dark">Нет откликов на вакансии организации</app-tooltip></q-badge>
                            </template> -->
                            
                            <template v-else-if="col.name === 'action'">
                                <q-btn-dropdown
                                    flat :dropdown-icon="mdiDotsHorizontal" class="text-primary" size="12px"
                                    padding="6px" no-icon-animation 
                                >
                                    <q-list class="comp-table__menu">
                                        <q-item :to="`/hr/company/${props.row.id}?tab=view`">
                                            <q-item-section avatar><q-icon :name="mdiEye" size="14px" color="secondary"/></q-item-section>
                                            <q-item-section><q-item-label>Просмотр</q-item-label> </q-item-section>
                                        </q-item>
                                        <q-item :to="`/hr/company/${props.row.id}`">
                                            <q-item-section avatar><q-icon :name="mdiPencil" size="14px" color="positive"/></q-item-section>
                                            <q-item-section><q-item-label>Редактировать</q-item-label></q-item-section>
                                        </q-item>
                                        <q-item v-if="props.row.status != 'archived'"
                                            clickable v-close-popup @click="changeStatus(props.row.id, props.row.name, 'archived')">
                                            <q-item-section avatar><q-icon :name="mdiPackageDown" size="14px"/></q-item-section>
                                            <q-item-section><q-item-label>В архив</q-item-label></q-item-section>
                                        </q-item>
                                        <q-item v-if="props.row.status == 'archived'"
                                            clickable v-close-popup @click="changeStatus(props.row.id, props.row.name, 'default')">
                                            <q-item-section avatar><q-icon :name="mdiPackageUp" size="14px"/></q-item-section>
                                            <q-item-section><q-item-label>Восстановить</q-item-label></q-item-section>
                                        </q-item>
                                        <q-item v-if="!props.row.vacancy_count"
                                            clickable v-close-popup @click="removeCompany(props.row.id, props.row.name)">
                                            <q-item-section avatar><q-icon :name="mdiClose" size="14px" color="negative"/></q-item-section>
                                            <q-item-section><q-item-label>Удалить</q-item-label></q-item-section>
                                        </q-item>
                                    </q-list>
                                </q-btn-dropdown>
                            </template>

                            <template v-else-if="col.name === 'author'">
                                <q-badge color="positive">
                                    {{ col.value || '—' }}
                                    <app-tooltip class="bg-dark">Личная страница создателя аккаунта</app-tooltip>
                                </q-badge>
                            </template>

                            <template v-else-if="col.name === 'createdon'">
                                <q-badge class="_light">
                                    {{ col.value }}
                                    <app-tooltip class="bg-dark">Дата создания профиля организации</app-tooltip>
                                </q-badge>
                            </template>

                            <template v-else>
                                <b>{{ col.value }}</b>
                            </template>
                        </q-td>
                    </q-tr>
                    <!-- скрытый контент -->
                    <q-tr v-show="props.expand" :props="props">
                        <q-td colspan="100%">
                            <div class="text-left">
                                <div class="comp-table__hidden">
                                    <div v-for=" i in hiddenColumns" class="comp-table__hidden-row row justify-between items-center no-wrap">
                                        <div><b>{{ findColumn(i).label }}</b></div>

                                        <div>
                                            <template v-if="i === 'vacancy_count'">
                                                <router-link v-if="props.row.vacancy_count" :to="`/hr/company/${props.row.id}/vacancies`">
                                                    <q-badge color="positive">
                                                        {{ props.row.vacancy_count }}
                                                        <app-tooltip class="bg-dark">Посмотреть все вакансии организации</app-tooltip>
                                                    </q-badge>
                                                </router-link>

                                                <q-badge v-else @click="createVacancy(props.row.id)" color="negative" class="cursor-pointer">
                                                    {{ props.row.vacancy_count }}
                                                    <app-tooltip class="bg-dark">Создать вакансию</app-tooltip>
                                                </q-badge>
                                            </template>

                                            <template v-else-if="i === 'users'">
                                                <q-badge color="negative">0<app-tooltip class="bg-dark">Пригласить специалиста в организацию</app-tooltip></q-badge>
                                            </template>

                                            <template v-else-if="i === 'feedback'">
                                                <q-badge color="negative">0<app-tooltip class="bg-dark">Нет откликов на вакансии организации</app-tooltip></q-badge>
                                            </template>

                                            <template v-else-if="i === 'author'">
                                                <q-badge color="positive">
                                                    {{ props.row[i] || '—' }}
                                                    <app-tooltip class="bg-dark">Личная страница создателя аккаунта</app-tooltip>
                                                </q-badge>
                                            </template>

                                            <template v-else-if="i === 'createdon'">
                                                <q-badge class="_light">
                                                    {{ props.row[i] }}
                                                    <app-tooltip class="bg-dark">Дата создания профиля организации</app-tooltip>
                                                </q-badge>
                                            </template>

                                            <template v-else-if="i === 'action'">
                                                <q-btn-dropdown
                                                    flat :dropdown-icon="mdiDotsHorizontal" class="text-primary" size="12px"
                                                    padding="6px" no-icon-animation 
                                                >
                                                    <q-list class="comp-table__menu">
                                                        <q-item :to="`/company/${props.row.id}?tab=view`">
                                                            <q-item-section avatar><q-icon :name="mdiEye" size="14px" color="secondary"/></q-item-section>
                                                            <q-item-section><q-item-label>Просмотр</q-item-label> </q-item-section>
                                                        </q-item>
                                                        <q-item :to="`/company/${props.row.id}/edit`">
                                                            <q-item-section avatar><q-icon :name="mdiPencil" size="14px" color="positive"/></q-item-section>
                                                            <q-item-section><q-item-label>Редактировать</q-item-label></q-item-section>
                                                        </q-item>
                                                        <q-item v-if="props.row.status != 'archived'"
                                                            clickable v-close-popup @click="changeStatus(props.row.id, props.row.name, 'archived')">
                                                            <q-item-section avatar><q-icon :name="mdiPackageDown" size="14px"/></q-item-section>
                                                            <q-item-section><q-item-label>В архив</q-item-label></q-item-section>
                                                        </q-item>
                                                        <q-item v-if="props.row.status == 'archived'"
                                                            clickable v-close-popup @click="changeStatus(props.row.id, props.row.name, 'default')">
                                                            <q-item-section avatar><q-icon :name="mdiPackageUp" size="14px"/></q-item-section>
                                                            <q-item-section><q-item-label>Восстановить</q-item-label></q-item-section>
                                                        </q-item>
                                                        <q-item v-if="!props.row.vacancy_count"
                                                            clickable v-close-popup @click="removeCompany(props.row.id, props.row.name)">
                                                            <q-item-section avatar><q-icon :name="mdiClose" size="14px" color="negative"/></q-item-section>
                                                            <q-item-section><q-item-label>Удалить</q-item-label></q-item-section>
                                                        </q-item>
                                                    </q-list>
                                                </q-btn-dropdown>
                                            </template>

                                            <template v-else>
                                                <b>{{ props.row[i] }}</b>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </q-td>
                    </q-tr>
                </template>
            </q-table>
        </div>
    </base-page>
</template>

<!-- <style lang="scss">
.q-menu:has(.comp-table__menu) {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    padding: 0.5rem 0;

    .q-item {
        min-height: 40px;
    }

    .q-item__section--side {
        padding-right: 8px;
    }
}

.comp-table {
    td,
    th {
        font-size: 1em !important;

        &:first-child {
            padding: 0;
        }
    }

    th {
        font-weight: 700;
        padding-top: 1rem;
        padding-bottom: 1rem;
        background: #F6F6F7;
    }

    &__expand-btn {
        .q-focus-helper {
            display: none;
        }
    }

    &__hidden {
        max-width: min-content;
        padding-left: 12px;

        &-row {
            padding: 0.5rem 0;
            
            &:not(:last-child) {
                border-bottom: 1px solid #efefef;
            }

            & > div:first-child {
                margin-right: 1em;
            }
        }
    }

    .q-badge {
        font-weight: 600;

        &._light {
            background: #e2e7f1 !important;
            color: #1e2139
        }
    }

    a {
        display: inline-block;
        text-decoration: none;
        max-width: 240px;
        white-space: normal;
    }
}
</style> -->