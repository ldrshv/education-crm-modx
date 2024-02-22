<script setup>
import { ref, defineProps } from 'vue'
import AppTooltip from '../components/AppTooltip.vue'

const props = defineProps({
    tooltip: {},
    type: {},
    value: {},
    link: {},
})
</script>

<template>
    <template v-if="type == 'badge-count'">
        <router-link :to="link">
            <q-badge :color="value ? 'positive' : 'negative'" >
                {{ value }}
                <app-tooltip class="bg-dark">{{ tooltip }}</app-tooltip>
            </q-badge>
        </router-link>
    </template>
</template>