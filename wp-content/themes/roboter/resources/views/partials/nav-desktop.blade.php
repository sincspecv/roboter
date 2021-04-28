<nav class="nav-primary show-for-large">
  <div class="nav-container grid-container">
    @if(has_nav_menu('primary_navigation'))
      {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav grid-x align-center', 'walker' => new App\Navigation\Foundation(),]) !!}
    @endif
  </div>
</nav>
