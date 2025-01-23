
let permissions = {
    methods: {
        getAllForDirectoryIncomeSources: function() {
            return [
                'income_source.view',
                'income_source.create',
                'income_source.update',
                'income_source.delete',
            ]
        },
        getAllForDirectoryStageAgreement: function() {
            return [
                'stage_agreement.view',
                'stage_agreement.create',
                'stage_agreement.update',
                'stage_agreement.delete',
            ]
        },
        getAllForDirectoryDistricts: function() {
            return [
                'districts.view',
                'districts.create',
                'districts.update',
                'districts.delete',
            ]
        },
        getAllForDirectories: function () {
            return this.getAllForDirectoryDistricts().concat(this.getAllForDirectoryStageAgreement()).concat(this.getAllForDirectoryIncomeSources());
        }
    }
}

export default permissions;