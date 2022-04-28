const App = {
    data() {
        return {
            isLoggedIn: false, // авторизован или нет
            loadingContent: false,
            username: '',
            nameUser: '',
            user: this.username = localStorage.getItem('username'),
            connection: '',
            success: '',
            message: '',
            BookingCode: '',
            description: '',
            status: 0,
            errorsArr: [],
        }
    },
    created() {
        if (localStorage.getItem('token') != undefined) {
            this.isLoggedIn = true
            this.username = localStorage.getItem('username')
        } else {
            this.isLoggedIn = false
            this.username = ''
        }
    },
    methods: {

        formFeedBack() {
            /**
             * показываем, что что-то происходит, обращаемся к АПИ 
             * это занимает время, поэтому показывам Loading...
             */
            this.loadingContent = true

            /**
             * Send request to api
             */

            fetch('http://127.0.0.1:8000/api/feedback', {
                method: 'post',
                body: JSON.stringify({
                    nameUser: this.nameUser,
                    connection: this.connection,
                    message: this.message,
                    status: this.status,
                }),
                headers: {
                    'content-type': 'application/json'
                }
            })
                .then(res => res.json()) // Get response from api & turn it to json format
                .then(res => {
                    if (res.user !== undefined) { // if api success, it returns user
                        location.href = 'index.html'
                        this.success = 'Данные оптравленны';
                        
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
        },

        ClosingBookings() {
            /**
             * показываем, что что-то происходит, обращаемся к АПИ 
             * это занимает время, поэтому показывам Loading...
             */
            this.loadingContent = true

            /**
             * Send request to api
             */

            fetch('http://127.0.0.1:8000/api/closingBooking', {
                method: 'post',
                body: JSON.stringify({
                    username: this.username,
                    BookingCode: this.BookingCode,
                    description: this.description,
                    status: this.status,
                }),
                headers: {
                    'content-type': 'application/json'
                }
            })
                .then(res => res.json()) // Get response from api & turn it to json format
                .then(res => {
                    if (res.user !== undefined) { // if api success, it returns user
                        location.href = 'index.html'
                        this.success = 'Данные оптравленны';
                        
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
        },
        
    }
}

Vue.createApp(App).mount('#app')