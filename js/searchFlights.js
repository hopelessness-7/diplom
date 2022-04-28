const App = {
    data() {
        return {
            isLoggedIn: false, // авторизован или нет
            username: '',
            from: localStorage.getItem('from'),
            to: localStorage.getItem('to'),
            date1: localStorage.getItem('date1'),
            date2: localStorage.getItem('date2'),
            passengers: localStorage.getItem('passengers'),
            flights: null, // object with flights, it will be full after api request
            errorsArr: [],
            timeBetweenStart: '',
            timeBetweenEnd: '',
            filtering: false,
            filteredFlightsTo: [],
            filteredFlightsBack: [],
            sortPoperty: 'FLIGHTTIME',
            loadingContent: false,
            allAirport: null,
            /**
             * так на данной странице мы будем регулировать какое окно показывать
             * окно поиска рейсов
             * или
             * окно бронирование рейсов
             */
            page: {
                searchWindowOpened: true, // по умолчанию всегда окно поиска рейсов активно
                bookingWindowOpened: false // а при нажатии на Go To Booking активным станет окно бронирования
            },
            checkedFlights: {
                checkedToFlight: null,
                checkedBackFlight: null
            }, //выбранные рейсы
            passengersInBooking: [],
            passenger: {
                first_name: '',
                last_name: '',
                birth_date: '',
                document_number: ''
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
        searchFlights() {
            /**
             * показываем, что что-то происходит, обращаемся к АПИ поиска рейсов
             * это занимает время, поэтому показывам Loading...
             */
            this.loadingContent = true

            /**
             * показать все рейсы - то есть скрыть div с отфильтрованными
             * рейсами и показать div со всеми найденными рейсами
             */
            this.filtering = false

            /**
             * очистить форму фильтрации, если она заполнена
             */
            this.timeBetweenEnd = ''
            this.timeBetweenStart = ''

            let queryString = ''

            /**
             * check if returning date is empty
             */
            if (this.date2 !== '') {
                queryString = `?from=${this.from}&to=${this.to}&date1=${this.date1}&date2=${this.date2}&passengers=${this.passengers}`
            } else {
                queryString = `?from=${this.from}&to=${this.to}&date1=${this.date1}&passengers=${this.passengers}`
            }

            /**
             * Send request to api
             */
            fetch('http://127.0.0.1:8000/api/flight' + queryString)
                .then(res => res.json()) // Get response from api & turn it to json format
                .then(res => {
                    if (res.data !== undefined) { // if api return data
                        this.flights = res.data
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
        
        countFlightTime(fisrtTime, secondTime) {
            let getDate = (string) => new Date(0, 0, 0, string.split(':')[0], string.split(':')[1]);
            let different = (getDate(secondTime) - getDate(fisrtTime));
            let differentRes, hours, minuts;
            if (different > 0) {
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
        filterTimeBetween() {
            this.filtering = true // показать отфильтрованные рейсы

            let getDate = (string) => new Date(0, 0, 0, string.split(':')[0], string.split(':')[1]);
            let time1 = getDate(this.timeBetweenStart)
            let time2 = getDate(this.timeBetweenEnd)

            this.filteredFlightsTo = this.flights.flights_to.filter(function (elem) {
                let departureTime = getDate(elem.from_airport.time)
                return departureTime >= time1 && departureTime <= time2
            })

            /**
             * if you have flights_back too
             */
            this.filteredFlightsBack = this.flights.flights_back.filter(function (elem) {
                let departureTime = getDate(elem.from_airport.time)
                return departureTime >= time1 && departureTime <= time2
            })
        },
        sortByProperty() {
            /**
             * показать все рейсы - то есть скрыть div с отфильтрованными
             * рейсами и показать div со всеми найденными рейсами
             */
            this.filtering = false

            /**
             * очистить форму фильтрации, если она заполнена
             */
            this.timeBetweenEnd = ''
            this.timeBetweenStart = ''

            if (this.sortPoperty === 'FLIGHTTIME') {
                /**
                 * сортируем массивы с рейсами (прямые,обратные) по времени полета
                 */
                let vm = this

                this.flights.flights_to.sort(function (a, b) {
                    let aFlightTime = vm.countFlightTime(a.from_airport.time, a.to_airport.time)
                    let bFlightTime = vm.countFlightTime(b.from_airport.time, b.to_airport.time)
                    let aMinutesTotal = aFlightTime.split(':')[0] * 60 + parseInt(aFlightTime.split(':')[1])
                    let bMinutesTotal = bFlightTime.split(':')[0] * 60 + parseInt(bFlightTime.split(':')[1])

                    return aMinutesTotal - bMinutesTotal
                })
                this.flights.flights_back.sort(function (a, b) {
                    let aFlightTime = vm.countFlightTime(a.from_airport.time, a.to_airport.time)
                    let bFlightTime = vm.countFlightTime(b.from_airport.time, b.to_airport.time)
                    let aMinutesTotal = aFlightTime.split(':')[0] * 60 + parseInt(aFlightTime.split(':')[1])
                    let bMinutesTotal = bFlightTime.split(':')[0] * 60 + parseInt(bFlightTime.split(':')[1])

                    return aMinutesTotal - bMinutesTotal
                })
            }
            if (this.sortPoperty === 'COST') {
                /**
                 * сортируем массивы с рейсами (прямые,обратные) по цене
                 */
                this.flights.flights_to.sort(function (a, b) {
                    return a.cost - b.cost
                })
                this.flights.flights_back.sort(function (a, b) {
                    return a.cost - b.cost
                })
            }
        },
        goToBooking() {
            /**
             * делаем активным окно бронирования и скрываем окно поиска рейсов
             */
            this.page.searchWindowOpened = false
            this.page.bookingWindowOpened = true

            /**
             * Если пользователь авторизован, то заполняем форму его данными
             */
            if (localStorage.getItem('token') != undefined) {
                this.passenger = {
                    first_name: localStorage.getItem('first_name'),
                    last_name: localStorage.getItem('last_name'),
                    document_number: localStorage.getItem('document_number')
                }
            }
        },
        addPassenger() {
            this.passengersInBooking.push(this.passenger) // добавляем в массив с пассажирами пассажира
            this.passenger = { // и очищаем врменный объект пассажир
                first_name: '',
                last_name: '',
                birth_date: '',
                document_number: ''
            }
        },
        deletePassenger(index) {
            // нельзя удалить пассажира, если он единственный
            if (this.passengersInBooking.length === 1) {
                alert('At least one passenger must be added')
                return
            }
            this.passengersInBooking.splice(index, 1)
        },
        book() {
            /**
             * показываем, что что-то происходит, обращаемся к АПИ поиска рейсов
             * это занимает время, поэтому показывам Loading...
             */
            this.loadingContent = true

            // формируем объект для конвертирвания его в JSON
            let obj = {
                flight_from: {
                    id: this.checkedFlights.checkedToFlight.id,
                    date: this.checkedFlights.checkedToFlight.from_airport.date
                },
                // flight_back: {
                //     id
                // },
                passengers: this.passengersInBooking
            }

            // если выбран еще и обратный рейс
            if (this.checkedFlights.checkedBackFlight) {
                obj.flight_back = {
                    id: this.checkedFlights.checkedBackFlight.id,
                    date: this.checkedFlights.checkedBackFlight.from_airport.date
                }
            }

            fetch('http://127.0.0.1:8000/api/booking', {
                method: 'post',
                body: JSON.stringify(obj),
                headers: {
                    'content-type': 'application/json'
                }

            })
                .then(res => res.json())
                .then(res => {
                    if (res.data !== undefined) { // if api success, it returns user
                        alert(res.data.code)
                        location.href = 'profile.html'
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
