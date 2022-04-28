const App = {
    data () {
        return {
            isLoggedIn: false, // авторизован или нет
            username: '',
            loadingContent: false,
            bookingCode: localStorage.getItem('code'),
            booking: null, // найденная бронь
            seatSection: false, // неактивный блок выбора места
            obj: {
                passenger: '',
                seat: '',
                type: ''
            }, //объект для формирования (JSON) тела запроса
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
        findBooking() {
            /**
             * показываем, что что-то происходит, обращаемся к АПИ поиска рейсов
             * это занимает время, поэтому показывам Loading...
             */
            this.loadingContent = true

            // закрываем блок выбора места и очищаем временный объект
            this.seatSection = false
            this.obj = {
                passenger: '',
                seat: '',
                type: ''
            }

            fetch('http://127.0.0.1:8000/api/booking/' + this.bookingCode)
            .then(res => res.json())
            .then(res => {
                if(res.data !== undefined) { // if api return data
                    this.booking = res.data
                }
                if(res['not found'] !== undefined) { // if api return validation errors
                    alert('Not found')
                }
                this.loadingContent = false
            })
            .catch(err => console.log(err))
        },
        countFlightTime(fisrtTime, secondTime) {
            let getDate = (string) => new Date(0, 0,0, string.split(':')[0], string.split(':')[1]);
            let different = (getDate(secondTime) - getDate(fisrtTime));
            let differentRes, hours, minuts;
            if(different > 0) {
                differentRes = different;
                hours = Math.floor((differentRes % 86400000) / 3600000);
                minuts = Math.round(((differentRes % 86400000) % 3600000) / 60000);
            } else {
                differentRes = Math.abs((getDate(fisrtTime) - getDate(secondTime)));
                hours = Math.floor(24 - (differentRes % 86400000) / 3600000);
                minuts = Math.round(60 - ((differentRes % 86400000) % 3600000) / 60000);
            }
            let result = hours + ':' + minuts;
            return result
        },
        goToChooseSeat(p, type) {
            // активируем блок выбора места
            this.seatSection = true

            // заполняем obj врeменными данными
            this.obj.passenger = p.id
            this.obj.type = type

            // прокрутить до самого низа
            setTimeout(function() {
                window.scrollBy(0, 20000)
            }, 0)
            
        },
        chooseSeat() {
            /**
             * показываем, что что-то происходит, обращаемся к АПИ поиска рейсов
             * это занимает время, поэтому показывам Loading...
             */
            this.loadingContent = true

            /**
             * Send request to api
             */
            fetch('http://127.0.0.1:8000/api/booking/' + this.bookingCode + '/seat', {
                method: 'PATCH',
                body: JSON.stringify(this.obj),
                headers: {
                    'content-type': 'application/json'
                }
            })
            .then(res => res.json()) // Get response from api & turn it to json format
            .then(res => {
                if(res.data !== undefined) { // if api success, it returns user
                    this.findBooking()
                    
                    // закрываем блок выбора места и очищаем временный объект
                    this.seatSection = false
                    this.obj = {
                        passenger: '',
                        seat: '',
                        type: ''
                    }
                }
                if(res.error !== undefined) { // if api return validation errors
                    
                    this.errorsArr = []
                    
                    //if validation errors occured
                    if(res.error.errors !== undefined) {
                        
                        let errorValidation = res.error.errors
                        for (let key in errorValidation) {
                            for(let i = 0; i<errorValidation[key].length; i++) {
                                this.errorsArr.push(errorValidation[key][i])
                            }
                        }
                    }

                    // if other errors
                    else {
                        this.errorsArr.push(res.error.message)
                    }
                }
                this.loadingContent = false
            })
            .catch()
        }
    }
}

Vue.createApp(App).mount('#app')