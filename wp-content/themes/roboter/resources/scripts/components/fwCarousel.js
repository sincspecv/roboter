import _ from 'lodash-es';

const fwCarousel = {
    init() {
        this.id = Math.floor(Math.random() * (7147 - 2949 + 1)) + 2949;
        this.slides = Array.from(this.$refs.carousel.querySelectorAll('.carousel-item'));
    },
    id: null,
    slides: [],
    activeSlide: 0,
    scroll(slideIndex) {
        const selector = `#slide-${slideIndex}-${this.id}`;
        const el = document.querySelector(selector);

        if (el != undefined) {
            this.activeSlide = slideIndex;
            el.scrollIntoView({behavior: 'smooth', block: 'nearest', inline: 'start'})
        }
    }
}

export default fwCarousel;