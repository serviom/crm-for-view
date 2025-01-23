let priceFormatter = {
    methods: {
        priceFormat(value, locale = 'en-US', maxFD = 0) {
            const formatter = new Intl.NumberFormat(locale, {
                style: 'currency',
                currency: 'USD',
                maximumFractionDigits: maxFD,
            })

            return formatter.format(value)
        },
    }
}

export default priceFormatter;