<script setup>
    import { ref } from 'vue'
    import { biEye, biEyeSlash } from '@quasar/extras/bootstrap-icons'

    const props = defineProps({
        modelVal: {},
        label: {
            default: 'Пароль'
        },
        name: {
            default: 'password'
        },
    })

    const showPwd = ref(false)

    const emit = defineEmits(['update:modelVal'])
</script>

<template>
    <q-input
        @update="$emit('update:modelVal', $event.target.value)"
        :value="modelVal"
        :type="showPwd ? 'text' : 'password'"
        :name="name"
        :label="label"
        outlined
    >
        <template v-slot:append>
            <q-icon
                @click="showPwd = !showPwd"
                :name="showPwd ? biEyeSlash : biEye"
                class="cursor-pointer"
            />
        </template>
    </q-input>
</template>
