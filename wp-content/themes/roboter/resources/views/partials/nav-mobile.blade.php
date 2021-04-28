<nav class="nav-mobile hide-for-large">
  <a class="site-brand__logo" href="{{ home_url('/') }}">{!! $site_brand !!}</a>
  @if(has_nav_menu('primary_navigation'))
    {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'vertical menu drilldown', 'walker' => new App\Navigation\FoundationDrilldown(),]) !!}
  @endif
</nav>
