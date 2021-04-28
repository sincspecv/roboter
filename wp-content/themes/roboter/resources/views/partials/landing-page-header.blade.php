<header class="landing-page-banner {{ get_field('background_color') }}">
  <div class="grid-container">
    <div class="grid-x grid-padding-x grid-padding-y">
      <div class="site-brand cell medium-2 large-4">
        <figure class="site-brand__logo">{!! $site_brand !!}</figure>
      </div>
      <aside class="cell auto align-self-middle align-self-right">
        @include('elements.landing-page-hello-bar')
      </aside>
    </div>
  </div>
</header>
<div class="mobile-logo hide-for-large">
  <div class="grid-container">
    <div class="grid-x grid-padding-x grid-padding-y">
      <div class="site-brand cell small-4 medium-2 large-4">
        <figure class="site-brand__logo">{!! $site_brand !!}</figure>
      </div>
    </div>
  </div>
</div>
