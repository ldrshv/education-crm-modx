<script setup>
    import { ref } from 'vue'
    import { mdiEyeOutline, mdiEyeOffOutline } from '@quasar/extras/mdi-v6'

    const props = defineProps({
        modelVal: {},
        opts: {},
        error: {},
        form: {}
    })

    const label = ref(props.opts.label || '—')
    const name = ref(props.opts.name || props.opts.field )
    let rules = ref(null);
    const type = ref(props.opts.type || 'text')

    const validate = props.opts.validate || []

    if (type.value === 'email') {
        validate.push('email')
    }
    if (type.value === 'tel') {
        validate.push('phone')
    }
    if (type.value === 'password') {
        validate.push('required')
    }

    if (validate.length) {
        rules.value = [];
        if (validate.includes('required')) {
            rules.value.push(val => val && val.length > 0 || 'Заполните это поле')
        }
        if (validate.includes('email')) {
            const emailRegex = /^(?:[A-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[A-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9]{2,}(?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/i
            rules.value.push(val => (!val || emailRegex.test(val)) || 'Введите корректный email')
        }
        if (validate.includes('phone')) {
            const phoneRegex = /^[0-9 ()\-+]{5,18}$/
            rules.value.push(val => (!val || phoneRegex.test(val)) || 'Введите корректный номер телефона')
        }
        if (validate.includes('confirm_password')) {
            rules.value.push(val => val === props.form.new_password || 'Пароли не совпадают')
        }
    }

    if (props.opts.rules && rules.value) {
        rules = ref(rules.value.concat(props.opts.rules))
    }

    const showPwd = ref(false)
    
    const emit = defineEmits(['update:modelVal'])
</script>

<template>
    
    <q-input
        @update="$emit('update:modelVal', $event.target.value)"
        :name="name"
        :type="type == 'password' && showPwd ? 'text' : type"
        :label="label"
        :rules="rules"
        :hide-bottom-space="true"
        :class="validate.includes('required') && '_required'"
        :error="!!error"
        :error-message="error"
        lazy-rules
        outlined
    >
        <template v-if="type == 'password'" v-slot:append>
            <q-icon
                @click="showPwd = !showPwd"
                :name="showPwd ? mdiEyeOffOutline : mdiEyeOutline"
                class="cursor-pointer"
            />
        </template>
        <!-- <template v-slot:append>
            <q-icon name="event" class="cursor-pointer">
                <q-popup-proxy cover transition-show="scale" transition-hide="scale">
                    <q-date @update:model-value="$emit('update:modelVal', $event)">
                        <div class="row items-center justify-end">
                            <q-btn v-close-popup label="Close" color="primary" flat />
                        </div>
                    </q-date>
                </q-popup-proxy>
            </q-icon>
        </template> -->
    </q-input>
</template>
