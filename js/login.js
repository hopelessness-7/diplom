const App = {
    data () {
        return {
            isLoggedIn: false, // авторизован или нет
            username: '',
            phone: '',
            password: '',
            errorsArr: [],
            loadingContent: false,
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
        login() {
            /**
             * показываем, что что-то происходит, обращаемся к АПИ входа
             * это занимает время, поэтому показывам Loading...
             */
             this.loadingContent = true

             /**
              * Send request to api
              */
            fetch('http://127.0.0.1:8000/api/login', {
            method: 'post',
            body: JSON.stringify({
                phone: this.phone,
                password: this.password,
            }),
            headers: {
                'content-type': 'application/json'
            }
            })
            .then(res => res.json()) // Get response from api & turn it to json format
            .then(res => {
                if (res.data !== undefined) {
                    localStorage.setItem('token', res.data.token.original.access_token) // запоминаем токен пользователя
                    localStorage.setItem('username', res.data.token.original.user.first_name) // запоминаем имя пользователя для менюшки наверху
                    localStorage.setItem('first_name', res.data.token.original.user.first_name) // запоминаем имя пользователя, потом если он захочет забронировать
                    localStorage.setItem('last_name', res.data.token.original.user.last_name) // запоминаем фамилию пользователя, потом если он захочет забронировать
                    // localStorage.setItem('birth_date', res.data.token.original.user.birth_date) // запоминаем дата рождения пользователя, потом если он захочет забронировать
                    localStorage.setItem('document_number', res.data.token.original.user.document_number) // запоминаем номер документа пользователя, потом если он захочет забронировать
                    location.href = 'profile.html'
                }
                if(res.error !== undefined) { // if api return validation errors
                    this.errorsArr = []

                    // if invalid credentials
                    if(res.error.code === 401) {
                        this.errorsArr.push(res.error.errors)
                    }

                    //if validation errors occured
                    if(res.error.code === 422) {
                        let errorValidation = res.error.errors
                        for (let key in errorValidation) {
                            for(let i = 0; i<errorValidation[key].length; i++) {
                                this.errorsArr.push(errorValidation[key][i])
                            }
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

