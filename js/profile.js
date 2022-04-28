const App = {
    data () {
        return {
            isLoggedIn: false, // авторизован или нет
            username: '',
            loadingContent: false,
            user: null,
            myBookings: [],

            /**
             * все свойства ниже, нужны для того, чтобы при
             * клике на номер брони происходило тоже самое
             * что и на странице booking.html
             */
            bookingCode: '',
            booking: null, // найденная бронь
            seatSection: false, // неактивный блок выбора места
            obj: {
                passenger: '',
                seat: '',
                type: ''
            }, //объект для формирования (JSON) тела запроса
            errorsArr: [],
            page: {
                showMyBookingsBlock: true,
                showBookingManagementBlock: false
            }
            
        }
    },
    created() {
        if (localStorage.getItem('token') != undefined) {
            this.isLoggedIn = true
            this.username = localStorage.getItem('username')
        } else {
            this.isLoggedIn = false
            this.username = ''
            location.href = 'login.html' // если защищенная страница, то перенаправляем на Логин
        }

        this.getUserInfo();
        this.getMyBookings();
    },
    methods: {
        logout() {
            localStorage.removeItem('token')
            localStorage.removeItem('username')
            localStorage.removeItem('first_name')
            localStorage.removeItem('last_name')
            // localStorage.removeItem('birth_date')
            localStorage.removeItem('document_number')
            this.isLoggedIn = false
            this.username = ''
            location.href = 'index.html'
        },
        getUserInfo() {
            /**
             * показываем, что что-то происходит, обращаемся к АПИ поиска рейсов
             * это занимает время, поэтому показывам Loading...
             */
            this.loadingContent = true

            const token = localStorage.getItem('token');

            if(!token) {
                alert('Unauthorized')
                location.href="login.html"
            } else {
                fetch('http://127.0.0.1:8000/api/user/?token=' + token)
                .then(res => res.json())
                .then(res => {

                    // если к нам попал токен, но он неверный, а значит подозрительный, то вызываем функцию logout
                    if(res.error !== undefined) {
                        alert('Unauthorized')
                        this.logout()
                        return
                    }
                    
                    // if api return user
                    this.user = res
                    
                    this.loadingContent = false
                })
                .catch(err => console.log(err))
            }
        },

        getMyBookings() {
            /**
             * показываем, что что-то происходит, обращаемся к АПИ поиска рейсов
             * это занимает время, поэтому показывам Loading...
             */
            this.loadingContent = true

            const token = localStorage.getItem('token');

            if(!token) {
                alert('Unauthorized')
                location.href="login.html"
            } else {
                fetch('http://127.0.0.1:8000/api/user/booking?token=' + token)
                .then(res => res.json())
                .then(res => {
                    if(res.data !== undefined) { // if api return data
                        this.myBookings = res.data.items
                    }

                    // если к нам попал токен, но он неверный, а значит подозрительный, то вызываем функцию logout
                    if(res.error !== undefined) {
                        alert('Unauthorized')
                        this.logout()
                    }
                    
                    this.loadingContent = false
                })
                .catch(err => console.log(err))
            }
        },
    }
}

Vue.createApp(App).mount('#app')
