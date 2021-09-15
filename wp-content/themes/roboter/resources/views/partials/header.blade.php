<header class="banner">
  <div class="grid-container">
    <div class="grid-x grid-padding-x grid-padding-y align-middle">
      <div class="site-brand cell small-10 large-3 shrink align-left">
        <a class="site-brand__logo" href="{{ home_url('/') }}">{!! $site_brand !!} <span class="show-for-sr">{!! get_bloginfo('name', 'display') !!}</span></a>
      </div>
      <div class="nav-wrap cell large-auto align-right show-for-large">
        @include('partials.nav-desktop')
      </div>
      @if($banner->button)
      <div class="cell shrink show-for-large align-right">
        <a href="{!! esc_url_raw($banner->button->url) !!}" class="button primary" target="{!! esc_attr($banner->button->target) !!}" style="margin:0;border-radius:0">{!! wp_kses($banner->button->title, 'tfr') !!}</a>
      </div>
      @endif
      @include('partials.nav-toggle')
    </div>
  </div>
  @include('partials.nav-mobile')
</header>