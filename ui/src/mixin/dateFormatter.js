let dateFormatter = {
    methods: {
        dateFormat: function (d = null) {
            let date = d ? new Date(d) : new Date()

            let day = date.getDate()
            if (day < 10) day = '0' + day

            let month = date.getMonth()
            if (month < 10) month = '0' + month

            let year = date.getFullYear()

            let hrs = date.getHours()
            if (hrs < 10) hrs = '0' + hrs

            let min = date.getMinutes()
            if (min < 10) min = '0' + min

            let sec = date.getSeconds()
            if (sec < 10) sec = '0' + sec

            return d ? `${day}.${month}.${year} ${hrs}:${min}:${sec}` : `${year}-${month}-${day} ${hrs}:${min}:${sec}`
        },
        dateParse: function(d) {
            let parts = d.split(' ')
            let date = parts[0].split('.')
            let time = parts[1].split(':')

            return new Date(parseInt(date[2], 10),
                parseInt(date[1], 10) - 1,
                parseInt(date[0], 10),
                parseInt(time[0], 10),
                parseInt(time[1], 10)
            )
        },
        dateFormatWithTimezone: function (isoDate  = null) {
            return this.$moment(isoDate).format('DD.MM.YYYY HH:mm');
            // const timezone = 'America/New_York';
            // console.log(date.tz(timezone).format('YYYY-MM-DD HH:mm:ss'));
        }
    }
}

export default dateFormatter;