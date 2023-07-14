import Alpine from 'alpinejs';
import imageCarousel from './imageCarousel';
import fwCarousel from './fwCarousel';

const components = {
    imageCarousel: imageCarousel,
    fwCarousel: fwCarousel
}

const initComponents = () => {
    document.addEventListener('alpine:init', function () {
        Object.keys(components).forEach(component => {
            Alpine.data(component, () => (components[component]));
        });
    });

    console.log(Alpine.data);
}
export default initComponents;