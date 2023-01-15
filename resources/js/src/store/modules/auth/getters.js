export default {
    isAuthenticated: state => !!state.user,
    tokenAuth: state => state.token,
    user: state => state.user,
}
