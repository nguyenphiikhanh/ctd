import Vue from "vue";

export default {
    alertSuccess({commit, dispatch}, message){
        Vue.$toast.success(message, {
            position: "bottom-right",
            timeout: 1961,
            closeOnClick: true,
            pauseOnFocusLoss: false,
            pauseOnHover: false,
            draggable: false,
            draggablePercent: 0.6,
            showCloseButtonOnHover: false,
            hideProgressBar: false,
            closeButton: "button",
            icon: true,
            rtl: false
        });
    },
    alertError({commit, dispatch}, message){
        Vue.$toast.error(message, {
            position: "bottom-right",
            timeout: 1961,
            closeOnClick: true,
            pauseOnFocusLoss: false,
            pauseOnHover: false,
            draggable: false,
            draggablePercent: 0.6,
            showCloseButtonOnHover: false,
            hideProgressBar: false,
            closeButton: "button",
            icon: true,
            rtl: false
        });
    },
}
