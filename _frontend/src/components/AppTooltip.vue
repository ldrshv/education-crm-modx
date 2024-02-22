<script setup>
</script>

<template>
    <q-tooltip
        anchor="top middle"
        self="bottom middle"
        :offset="[10, 10]"
        class="bg-dark"
>
        <slot></slot>
    </q-tooltip>
</template>