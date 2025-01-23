import {isArray} from "lodash";

let errorsFormatter = {
    methods: {
        allErrorsToString(errors) {
            let text  = '';

            for (const error in errors) {
                if (isArray(errors[error])) {
                    const ar = errors[error];
                    for (const e in ar) {
                        text += text ? (', ' + ar[e]) : ar[e];
                    }
                } else {
                    text += text ? (', ' + errors[error]) : errors[error];
                }
            }
            return text;
        },
        consoleLogByLocalEnv(...textErrors) {
            if (process.env.VUE_APP_ENV === 'local') {
                console.log(...textErrors);
            }
        },
        consoleLogByDevEnv(...textError) {
            if (process.env.VUE_APP_ENV === 'dev') {
                console.log(...textError);
            }
        },
    }
}

export default errorsFormatter;
