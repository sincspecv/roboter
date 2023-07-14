const global = {
    init() {
        // Fires before anything else happens
    },
    navElement: null,
    showNav: false,
    showSearchForm: false,
    transparentNav: true,
    toggleTransparentBg(element, background = 'primary') {
        this.transparentNav = window.scrollY <= 200;
    }
}

export default global;