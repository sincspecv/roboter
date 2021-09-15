<div class="footer-content grid-x grid-margin-x grid-padding-y align-center-middle">
  @if($footer->content)
    <div class="cell medium-8 align-center text-center footer-content__row">
      {!! $footer->content !!}
    </div>
  @endif
  @if($social_links)
    <div class="cell medium-8 align-center text-center footer-content__row">
      @include('partials.social-links')
    </div>
  @endif
  @if(has_nav_menu('footer_navigation'))
    {!! wp_nav_menu(['theme_location' => 'footer_navigation', 'menu_class' => 'nav grid-x align-center footer-navigation', 'walker' => new App\Navigation\Foundation(),]) !!}
  @endif
    <div class="cell medium-8 align-center text-center footer-content__copy-wrap">
      <span class="footer-content__copy">&copy; {!! date('Y') !!} {!! get_bloginfo('name') !!}</span>
    </div>
  @php wp_footer(); @endphp
</div>
