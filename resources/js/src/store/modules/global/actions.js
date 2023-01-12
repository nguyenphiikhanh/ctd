export default {
    alertError({commit, dispatch}){
        this.$toast.error("Lỗi", {
            position: "bottom-left",
            timeout: 2038,
            closeOnClick: false,
            pauseOnFocusLoss: false,
            pauseOnHover: false,
            draggable: false,
            showCloseButtonOnHover: false,
            hideProgressBar: true,
            closeButton: "button",
            icon: true,
        });
    },

    alertSuccess({commit, dispatch}){
        this.$toast.success("Thành công", {
            position: "bottom-left",
            timeout: 2038,
            closeOnClick: false,
            pauseOnFocusLoss: false,
            pauseOnHover: false,
            draggable: false,
            showCloseButtonOnHover: false,
            hideProgressBar: true,
            closeButton: "button",
            icon: true,
        });
    },
}
