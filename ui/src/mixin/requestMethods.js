import {mapActions} from "vuex";

let requestMethods = {
    methods: {
        ...mapActions({
            incrementSpinnerCounter: 'SpinnerModule/incrementSpinnerCounter',
            decrementSpinnerCounter: 'SpinnerModule/decrementSpinnerCounter',
        }),
        add_comment(entity, id, data, callback = ()=>{}){
            if(data.comment.length < 5){
                let message = 'Коментар закороткий';
                this.eventHub.$emit("doShowSnackbarEvent", true, message, 'warning', 5000);
            } else {
                if(data.comment.length > 1500){
                    let message = 'Коментар задовгий, має бути не більше 1500 символів.';
                    this.eventHub.$emit("doShowSnackbarEvent", true, message, 'warning', 5000);
                } else {
                    this.axios
                        .post(`${entity}/${id}/comment`, data)
                        .then(response => {
                            let message = response.data.message || "Success";
                            this.eventHub.$emit("doShowSnackbarEvent", true, message, 'success', 5000);
                        })
                        .then(() => {
                            callback()
                        })
                        .catch(error => {
                            let message = error.message || "Щось пішло не так :/";
                            this.eventHub.$emit("doShowSnackbarEvent", true, message, 'warning', 5000);
                        })
                }
            }
        },
    }
}

export default requestMethods;
