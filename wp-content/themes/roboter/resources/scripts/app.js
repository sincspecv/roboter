import domReady from '@roots/sage/client/dom-ready';
import Alpine from 'alpinejs';

// Alpine plugins
import collapse from '@alpinejs/collapse';
import intersect from '@alpinejs/intersect'

// App data and components
import initStores from './data/stores';
import initComponents from './components/components';

window.Alpine = Alpine

initStores();
initComponents();

Alpine.plugin(collapse);
Alpine.plugin(intersect);

Alpine.start();

/**
 * Application entrypoint
 */
domReady(async () => {
  // ...
});

/**
 * @see {@link https://webpack.js.org/api/hot-module-replacement/}
 */
if (import.meta.webpackHot) import.meta.webpackHot.accept(console.error);
