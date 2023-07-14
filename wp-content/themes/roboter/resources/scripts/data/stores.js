import Alpine from 'alpinejs';
import global from './global';

const stores = {
    global: global
}

const initStores = () => {
    document.addEventListener('alpine:init', function () {
        Object.keys(stores).forEach(store => {
            Alpine.store(store, (stores[store]));
        });
    });
}
export default initStores;