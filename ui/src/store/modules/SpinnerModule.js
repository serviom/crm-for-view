const SpinnerModule = {
    namespaced: true,
    state: () => ({
        count: 0,
    }),

    getters: {
        isShowSpinner (state) {
            return state.count
        },
    },
    mutations: {
        incrementSpinnerCounter (state) {
            state.count += 1;
        },

        decrementSpinnerCounter (state) {
            state.count -= 1;
        },
    },
    actions: {
        incrementSpinnerCounter (context, payload) {
            context.commit('incrementSpinnerCounter', payload);
        },
        decrementSpinnerCounter (context, payload) {
            context.commit('decrementSpinnerCounter', payload);
        },
    },
}

export default SpinnerModule;
