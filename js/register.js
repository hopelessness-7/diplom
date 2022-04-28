const App = {
    data() {
        return {
            isLoggedIn: false, // авторизован или нет
            username: '',
            first_name: '',
            last_name: '',
            phone: '',
            document_number: '',
            password: '',
            password_confirmation: '',
            errorsArr: [],
            loadingContent: false
        }
    },
    created() {
        if (localStorage.getItem('token') != undefined) {
            this.isLoggedIn = true
            this.username = localStorage.getItem('username')
            location.href = 'profile.html'
        } else {
            this.isLoggedIn = false
            this.username = ''
        }
    },
    methods: {
        register() {
            /**
             * показываем, что что-то происходит, обращаемся к АПИ регистрации
             * это занимает время, поэтому показывам Loading...
             */
            this.loadingContent = true

            /**
             * Send request to api
             */
            fetch('http://127.0.0.1:8000/api/register', {
                method: 'post',
                body: JSON.stringify({
                    first_name: this.first_name,
                    last_name: this.last_name,
                    phone: this.phone,
                    document_number: this.document_number,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                }),
                headers: {
                    'content-type': 'application/json'
                }
            })
                .then(res => res.json()) // Get response from api & turn it to json format
                .then(res => {
                    if (res.user !== undefined) { // if api success, it returns user
                        location.href = 'login.html'
                    }
                    if (res.error !== undefined) { // if api return validation errors
                        this.errorsArr = []
                        let errorValidation = res.error.errors
                        for (let key in errorValidation) {
                            for (let i = 0; i < errorValidation[key].length; i++) {
                                this.errorsArr.push(errorValidation[key][i])
                            }
                        }
                    }
                    this.loadingContent = false
                })
                .catch(err => console.log(err))
        }
    }
}

Vue.createApp(App).mount('#app')