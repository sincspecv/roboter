import _ from 'lodash-es';
import anime from 'animejs/lib/anime.es.js'

const imageCarousel = {
    carousel: null,
    images: [],
    containerHeight: '100%',
    heightTracker: 0,
    hasDots: false,
    centerSlide: {},
    firstSlide: {},
    lastSlide: {},
    leftSlide1: {},
    rightSlide1: {},
    leftSlide2: {},
    rightSlide2: {},
    offScreenSlides: [],
    players: [],
    scrollDistance: 0,
    animationFrame: {
        active: false,
        id: null,
        tick: 0,
    },
    animation: {
        left: null,
        right: null,
        running: false,
    },
    animationDuration: 500,
    initCarousel(element) {
        // const items = element.querySelectorAll('.image-carousel__image');

        if(!_.isUndefined(element.children)) {
            this.carousel = element;
            this.initTimelineObject();
            [].forEach.call(element.children, item => {
                const index = item.dataset.index;
                const slide = this.$refs[`slide_${index}`];
                const imageData = {
                    index: parseInt(index),
                    el: slide,
                    src: slide.querySelector('img').dataset.src,
                    pos() { return slide.getBoundingClientRect() },
                    styles: window.getComputedStyle(slide),
                    link: {
                        href: slide.querySelector('a') != undefined ? slide.querySelector('a').href : false,
                        text: slide.querySelector('a') != undefined ? slide.querySelector('a').innerText : false,
                    }
                }
                this.images.push(imageData);
            })
        }

        this.arrangeSlides(true);
    },
    setContainerHeight() {
        this.heightTracker = 0;
        this.$refs.image_carousel_container.style.height = 'auto';

        this.arrangeSlides();

        this.containerHeight = '';
        this.images.forEach(image => {
            if(image.el.offsetHeight > this.heightTracker) {
                this.heightTracker = image.el.offsetHeight;
            }
        });

        this.containerHeight = (this.heightTracker + 140) + 'px';
    },
    initTimelineObject() {
        this.animation.left = anime.timeline({
            easing: 'cubicBezier(0.550, 0.085, 0.455, 0.650)',
            duration: this.animationDuration,
            autoplay: false,
            loop: false,
            update: anim => {
                console.log('Left progress : '+Math.round(this.animation.left.progress)+'%');
            }
        });
        this.animation.right = anime.timeline({
            easing: 'cubicBezier(0.550, 0.085, 0.455, 0.650)',
            duration: this.animationDuration,
            autoplay: false,
            loop: false,
            update: anim => {
                console.log('Right progress : '+Math.round(this.animation.right.progress)+'%');
            }
        });
    },
    arrangeSlides(init = false) {
        // If we're on mobile we don't need to arrange the slides
        // in a 3d layout, so let's remove all inline styles
        if(window.innerWidth <= this.breakpoints().md.screen) {
            this.images.forEach(image => {
                image.el.style = '';
            });

            return true;
        }

        // If this is the initial arrangement on page load we need
        // to figure out what the center slide is before we can do
        // anything else
        if(init || _.isUndefined(this.centerSlide)) {
            const total = this.images.length;
            const mean = Math.round(total / 2);

            this.centerSlide = _.find(this.images, o => o.index === mean);
        }

        if(_.isUndefined(this.centerSlide)) {
            console.error("Unable to determine center slide in carousel.");
            return false;
        }

        this.styleSlides();
    },
    slideRight() {
        if(this.animation.running) {
            return false;
        }
        this.animation.running = true;
        this.animation.right.play()
        this.animation.right.finished.then(() => {
            this.animation.running = false;
            this.swap(this.centerSlide, this.centerSlide = this.rightSlide1, this.rightSlide1 = this.centerSlide);
            this.images.push(this.images.shift());
            this.getSlides();
        });
    },
    slideLeft() {
        if(this.animation.running) {
            return false;
        }
        this.animation.running = true;
        this.animation.left.play()
        this.animation.left.finished.then(() => {
            this.animation.running = false;
            this.swap(this.centerSlide, this.centerSlide = this.leftSlide1, this.leftSlide1 = this.centerSlide);
            this.images.unshift(this.images.pop());
            this.getSlides();
        });
    },
    getSlides() {
        // Get the slides surrounding the center slide
        if(this.centerSlide.index === this.images.length - 1) {
            this.leftSlide1 = _.find(this.images, o => o.index === this.centerSlide.index - 1);
            this.rightSlide1 = _.nth(this.images, 0);
            this.leftSlide2 = _.find(this.images, o => o.index === this.centerSlide.index - 2);
            this.rightSlide2 = _.nth(this.images,1);
        } else if(this.centerSlide.index === 0) {
            this.leftSlide1 = _.find(this.images, o => o.index === this.images.length - 1);
            this.rightSlide1 = _.find(this.images, o => o.index === this.centerSlide.index + 1);
            this.leftSlide2 = _.find(this.images, o => o.index === this.leftSlide1.index - 1);
            this.rightSlide2 = _.find(this.images, o => o.index === this.centerSlide.index + 2);
        } else {
            this.leftSlide1 = _.find(this.images, o => o.index === this.centerSlide.index - 1);
            this.rightSlide1 = _.find(this.images, o => o.index === this.centerSlide.index + 1);
            this.leftSlide2 = _.find(this.images, o => o.index === this.centerSlide.index - 2);
            this.rightSlide2 = _.find(this.images, o => o.index === this.centerSlide.index + 2);
        }

        const animateTo = this.getSlideLocations();

        // Get the first and last so we can move them to beginning/end
        // (depending on scroll direction) as necessary
        this.firstSlide = _.nth(this.images, 0);
        this.lastSlide = _.nth(this.images, this.images.length - 1);

        this.offScreenSlides = _.without(this.images, this.centerSlide, this.leftSlide1, this.rightSlide1, this.leftSlide2, this.rightSlide2);

        this.initTimelineObject();

        // Setup Left Animation
        this.animation.left
            .add({
                targets: this.leftSlide2.el,
                scale: 0.1,
                zIndex: -1,
                left: -10000,
                translateY: "-50%",
                opacity: {
                    value: 0,
                    duration: 100,
                },
                autoplay: false,
                loop: false,
                complete: () => {
                    this.animation.right.set(this.leftSlide2.el, {
                        scale: 0.1,
                        zIndex: -1,
                        opacity: 0,
                        left: -10000,
                        translateY: "-50%"
                    });
                }
            }, 0)
            .add({
                targets: this.leftSlide1.el,
                scale: 0.86,
                zIndex: animateTo.secondZ,
                left: `${animateTo.lTwoPos}px`,
                opacity: 1,
                translateY: "-50%",
                autoplay: false,
                loop: false,
                complete: () => {
                    this.animation.right.set(this.leftSlide1.el, {
                        scale: 0.86,
                        zIndex: animateTo.secondZ,
                        left: `${animateTo.lTwoPos}px`,
                        translateY: "-50%"
                    });
                }
            }, 0)
            .add({
                targets: this.centerSlide.el,
                scale: 0.90,
                zIndex: animateTo.firstZ,
                left: `${animateTo.lOnePos}px`,
                opacity: 1,
                translateY: "-50%",
                autoplay: false,
                loop: false,
                complete: () => {
                    this.animation.right.set(this.centerSlide.el, {
                        scale: 0.90,
                        zIndex: 8,
                        left: `${animateTo.lOnePos}px`,
                        translateY: "-50%"
                    });
                }
            }, 0)
            .add({
                targets: this.rightSlide1.el,
                scale: 1,
                zIndex: animateTo.centerZ,
                left: `${animateTo.centerPos}px`,
                opacity: 1,
                translateY: "-50%",
                autoplay: false,
                loop: false,
                complete: () => {
                    this.animation.right.set(this.rightSlide1.el, {
                        scale: 1,
                        zIndex: 9,
                        left: `${animateTo.centerPos}px`,
                        translateY: "-50%"
                    });
                }
            }, 0)
            .add({
                targets: this.rightSlide2.el,
                scale: 0.90,
                zIndex: animateTo.firstZ,
                left: `${animateTo.rOnePos}px`,
                opacity: 1,
                translateY: "-50%",
                autoplay: false,
                loop: false,
                complete: () => {
                    this.animation.right.set(this.rightSlide2.el, {
                        scale: 0.90,
                        zIndex: 8,
                        left: `${animateTo.rOnePos}px`,
                        translateY: "-50%"
                    });
                }
            }, 0)
            .add({
                targets: this.rightSlide2.el.nextElementSibling,
                scale: 0.86,
                zIndex: animateTo.secondZ,
                left: `${animateTo.rTwoPos}px`,
                translateY: "-50%",
                opacity: {
                    value: 1,
                    duration: 100,
                },
                autoplay: false,
                loop: false,
                complete: () => {
                    this.animation.right.set(this.rightSlide2.el.nextElementSibling, {
                        scale: 0.86,
                        zIndex: 7,
                        opacity: 1,
                        left: `${animateTo.rTwoPos}px`,
                        translateY: "-50%"
                    });
                }
            }, 0)


        // Setup Right Animation
        this.animation.right
            .add({
                targets: this.centerSlide.el,
                scale: 0.90,
                zIndex: animateTo.firstZ,
                left: `${animateTo.rOnePos}px`,
                opacity: 1,
                translateY: "-50%",
                autoplay: false,
                loop: false,
                complete: () => {
                    this.animation.left.set(this.centerSlide.el, {
                        scale: 0.90,
                        zIndex: animateTo.firstZ,
                        left: `${animateTo.rOnePos}px`,
                        translateY: "-50%"
                    })
                }
            }, 0)
            .add({
                targets: this.rightSlide1.el,
                scale: 0.86,
                zIndex: animateTo.secondZ,
                left: `${animateTo.rTwoPos}px`,
                opacity: 1,
                translateY: "-50%",
                autoplay: false,
                loop: false,
                complete: () => {
                    this.animation.left.set(this.rightSlide1.el, {
                        scale: 0.90,
                        zIndex: animateTo.secondZ,
                        left: `${animateTo.rOnePos}px`,
                        translateY: "-50%"
                    })
                }
            }, 0)
            .add({
                targets: this.rightSlide2.el,
                scale: 0.1,
                zIndex: -1,
                left: 10000,
                opacity: {
                    value: 0,
                    duration: 100,
                },
                translateY: "-50%",
                autoplay: false,
                loop: false,
                complete: () => {
                    this.animation.left.set(this.rightSlide2.el, {
                        scale: 0.1,
                        zIndex: -1,
                        left: 10000,
                        translateY: "-50%"
                    })
                }
            }, 0)
            .add({
                targets: this.leftSlide1.el,
                scale: 1,
                zIndex: animateTo.centerZ,
                left: `${animateTo.centerPos}px`,
                opacity: 1,
                autoplay: false,
                loop: false,
                complete: () => {
                    this.animation.left.set(this.leftSlide1.el, {
                        scale: 1,
                        zIndex: animateTo.centerZ,
                        left: `${animateTo.centerPos}px`,
                    })
                }
            }, 0)
            .add({
                targets: this.leftSlide2.el,
                scale: 0.90,
                zIndex: animateTo.firstZ,
                left: `${animateTo.lOnePos}px`,
                opacity: 1,
                autoplay: false,
                loop: false,
                complete: () => {
                    this.animation.left.set(this.leftSlide2.el, {
                        scale: 0.90,
                        zIndex: animateTo.firstZ,
                        left: `${animateTo.lOnePos}px`,
                    })
                }
            }, 0)
            .add({
                targets: this.leftSlide2.el.previousElementSibling,
                scale: 0.86,
                zIndex: animateTo.secondZ,
                left: `${animateTo.lTwoPos}px`,
                opacity: {
                    value: 1,
                    duration: 100,
                },
                autoplay: false,
                loop: false,
                complete: () => {
                    this.animation.left.set(this.leftSlide2.el.previousElementSibling, {
                        scale: 0.86,
                        zIndex: animateTo.secondZ,
                        left: `${animateTo.lTwoPos}px`,
                    })
                }
            }, 0)

    },
    getSlideLocations() {
        const centerHeight = this.centerSlide.el.offsetHeight;
        const centerWidth  = this.centerSlide.el.offsetWidth;
        const screenCenter = this.carousel.offsetWidth / 2;
        const centerPos    = screenCenter - (centerWidth / 2);
        const firstHeight  = centerHeight * 0.90 ;
        const secondHeight = firstHeight * 0.94 ;
        const lOnePos      = screenCenter - (this.leftSlide1.el.offsetWidth * 0.66);
        const lTwoPos      = screenCenter - (this.leftSlide1.el.offsetWidth * 0.85);
        const rOnePos      = lOnePos + (screenCenter - (this.rightSlide1.el.offsetWidth * 0.85));
        const rTwoPos      = lOnePos + (screenCenter - (this.rightSlide1.el.offsetWidth * 0.66));
        const firstPos     = this.leftSlide1.el.offsetWidth * 0.66;
        const secondPos    = firstPos + (this.leftSlide1.el.offsetWidth * 0.85);

        return {
            centerHeight: centerHeight,
            centerPos: centerPos,
            centerZ: "9",
            lOnePos: lOnePos,
            lTwoPos: lTwoPos,
            rOnePos: rOnePos,
            rTwoPos: rTwoPos,
            firstHeight: firstHeight,
            firstPos: firstPos,
            firstZ: "8",
            secondHeight: secondHeight,
            secondPos: secondPos,
            secondZ: "7"
        }
    },
    styleSlides() {
        this.getSlides();

        const locations = this.getSlideLocations();

        this.centerSlide.el.style.transform = "translateY(-50%) scale(1)";
        this.centerSlide.el.style.left = `${locations.centerPos}px`;
        this.centerSlide.el.style.zIndex = locations.centerZ;

        this.leftSlide1.el.style.transform = "translateY(-50%) scale(0.9)";
        this.leftSlide1.el.style.left = `${locations.lOnePos}px`;
        this.leftSlide1.el.style.zIndex = locations.firstZ;

        this.leftSlide2.el.style.transform = "translateY(-50%) scale(0.86)";
        this.leftSlide2.el.style.left = `${locations.lTwoPos}px`;
        this.leftSlide2.el.style.zIndex = locations.secondZ;

        this.rightSlide1.el.style.transform = "translateY(-50%) scale(0.9)";
        this.rightSlide1.el.style.left = `${locations.rOnePos}px`;
        this.rightSlide1.el.style.zIndex = locations.firstZ;

        this.rightSlide2.el.style.transform = "translateY(-50%) scale(0.86)";
        this.rightSlide2.el.style.left = `${locations.rTwoPos}px`;
        this.rightSlide2.el.style.zIndex = locations.secondZ;

        this.offScreenSlides.forEach(slide => {
            slide.el.style.transform = "translateY(-50%) scale(0.1)";
            slide.el.style.zIndex = "-1";
            slide.el.style.opacity = "0";

            switch(slide.index) {
                case (this.rightSlide2.index + 1):
                    slide.el.style.left = '100%';
                    break;
                case (this.leftSlide2.index - 1):
                    slide.el.style.left = '-100%';
                    break;
                default:
                    slide.el.style.left = '-100000px';
            }
        })
    },
    breakpoints() {
        return {
            lg: {
                screen: 1024,
                columns: 3,
                distance: (window.innerWidth / 3)
            },
            md: {
                screen: 768,
                columns: 2,
                distance: (window.innerWidth / 2)
            },
            sm: {
                screen: 640,
                columns: 1,
                distance: window.innerWidth
            }
        }
    },
    swap(x) {
        // If you don't know how this function works,
        // visit https://stackoverflow.com/questions/16151682/swap-two-objects-in-javascript
        return x;
    }
}

export default imageCarousel;