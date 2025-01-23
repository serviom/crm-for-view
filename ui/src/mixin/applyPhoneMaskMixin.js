let applyPhoneMaskMixin = {
    methods: {
        applyPhoneMask(value) {
            if(value.includes('(')) return value

            let mask = '+38 (###) ###-####';
            let i= 0;
            if (value) {
                return mask.replace(/#/g, () => value[i++]);
            } else {
                return '';
            }
        },
    }
}

export default applyPhoneMaskMixin;
