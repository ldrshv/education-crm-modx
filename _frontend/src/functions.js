import { Notify, Dialog } from 'quasar';
import axios from 'axios';

const showSuccess = function(message) {
    Notify.create({
        color: 'positive',
        message,
        position: 'top',
    })
}

const showError = function(message = 'неизвестная ошибка') {
    Dialog.create({
        title: 'Произошла ошибка',
        message: `Пожалуйста, перезагрузите страницу и попробуйте снова. Описание ошибки: ${message}`
    })
}

const request = function(params) {
    params.loading.value = true

    const axiosParams = {}
    if (params.headers) {
        axiosParams.headers = params.headers
    }
    if (params.hasFiles) {
        axiosParams.headers = axiosParams.headers || {}
        axiosParams.headers['Content-Type'] = 'multipart/form-data'
    }

    axios[params.method || 'get'](params.path, params.data || {}, axiosParams)
        .then((response) => {
            if (response.data?.data?.success) {
                params.successMessage && showSuccess(params.successMessage)
                params.success && params.success(response.data?.data?.data || {})
            } else {
                showError(response.data?.data?.message)
            }
        })
        .catch((error) => showError(error))
        .finally(() => {
            params.loading.value = false
            params.finally && params.finally()
        })
}

export { showSuccess, showError, request}