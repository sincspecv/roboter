import 'intersection-observer';
import Promise from 'promise-polyfill';
import {elementExists} from './elementExists';

export default () => {

    const images = document.querySelectorAll('.lazy');
    const options  = {
        rootMargin: '0px',
        threshold: 0.1,
    }

    const handleIntersection = entries => {
        entries.forEach(entry => {
            if(entry.intersectionRatio > 0) {
                loadImage(entry.target)
            }
        })
    }

    const loadImage = img => {
        const src = img.dataset.src;

        fetchImage(src).then(()=> {
            if(img.tagName === 'IMG') {
                img.src = src;
            } else {
                img.style.backgroundImage = `url("${src}")`;
            }
        }).catch(err => {
            console.log(err)
        })
    }

    const fetchImage = url => {
        return new Promise((resolve, reject) => {
            const img   = new Image();
            img.src     = url;
            img.onload  = resolve;
            img.onerror = reject;
        })
    }

    const observer = new IntersectionObserver(handleIntersection, options);

    if(elementExists(images)) {
        [].forEach.call(images, img => {
            observer.observe(img);
        })
    }
}
