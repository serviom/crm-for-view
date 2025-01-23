let reminder = {
    methods: {
        getTime(stage, roundTime = true) {
            let date = {
                date: null,
                time: null
            }
            let now = new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)
            date.date = now.toISOString().substr(0, 10)
            date.time = now.toISOString().substr(11, 5)

            if (stage) {
                if(stage.period_type === 2) { //days
                    now = new Date(now.setDate(now.getDate() + stage.period))
                } else if(stage.period_type === 1) { //hours
                    now = new Date(now.setHours(now.getHours() + stage.period))
                }

                date.date = now.toISOString().substr(0, 10)
                date.time = now.toISOString().substr(11, 5)
            }

            if(roundTime) {
                let array = date.time.split(':')
                array[1] = Math.ceil(array[1] / 10) * 10
                if(array[1] > 59) {
                    array[0] = Number(array[0]) + 1
                    array[1] = '00'
                }
                date.time = array.join(':')
            }

            return date
        },
    }
}

export default reminder;