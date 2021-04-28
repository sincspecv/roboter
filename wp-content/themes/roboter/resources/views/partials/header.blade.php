<header class="banner">
  <div class="grid-container">
    <div class="grid-x grid-padding-x grid-padding-y align-middle">
      <div class="site-brand cell small-10 large-4 align-left">
        <a class="site-brand__logo" href="{{ home_url('/') }}">{!! $site_brand !!}</a>
      </div>
      <aside class="cell auto align-middle grid-x align-right hello-bar-wrap show-for-large">
        @include('elements.hello-bar')
      </aside>
      @include('partials.nav-toggle')
    </div>
  </div>
  @include('partials.nav-desktop')
  @include('partials.nav-mobile')
</header>
