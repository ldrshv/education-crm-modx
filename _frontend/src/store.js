import { reactive, ref } from 'vue'
import { Dark } from 'quasar'
import { useLocalStorage } from '@vueuse/core'



const store = reactive({
    route: {},
    profile: {
        avatar: '',
        username: '',
    },

    // get darkTheme() {
        
    //     return darkTheme.value;
    //     // const value = localStorage.getItem("darkTheme");
    //     // if (value == 'undefined') {
    //     //     return false;
    //     // }
    //     // return value;

    //     const value = useLocalStorage('darkTheme').value
    //     console.log(value)
    //     // if (value == undefined) {
    //     //     value = 'light';
    //     // }
    //     // return value;
    // },
    // set darkTheme(value) {
    //     Dark.set(value);
    //     useLocalStorage('darkTheme', true)
    // }
});

// const getRoute = async function() {
//     const route = useRoute()
//     const router = useRouter()

//     await router.isReady()

//     router.beforeEach((to, from, next) => {
//         if (to.meta.title) {
//             document.title = to.meta.title + ' | HR PLUS'
//         }
//         next()
//     })
//     console.log(route.path)
// }

export { store }