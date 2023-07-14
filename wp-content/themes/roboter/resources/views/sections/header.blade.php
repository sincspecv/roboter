<header class="site-header bg-white-500 !bg-transparent max-w-screen fixed top-0 left-0 right-0 z-40 transition-colors ease-in-out duration-100" id="site-header" x-init="$watch('$store.global.transparentNav', isTransparent => isTransparent ? $el.classList.add('!bg-transparent') : $el.classList.remove('!bg-transparent'))" @scroll.window.debounce="$store.global.toggleTransparentBg($el)">
  <section class="main navbar h-42 mx-auto py-10 container">
    <div class="drawer fixed top-0 left-0 z-50 h-full bg-white" x-show="$store.global.showNav" @click.outside="$store.global.showNav = false">
      <!-- Mobile Navigation Toggle -->
      <input id="nav-toggle" type="checkbox" :checked="$store.global.showNav" class="drawer-toggle" />
      <label for="nav-toggle" class="drawer-overlay absolute top-10 right-10 z-10 cursor-pointer" @click="$store.global.showNav = !$store.global.showNav">
        <i class="fa fa-close text-white hover:text-accent text-xl py-4 px-10 text-4xl"></i>
        <span class="sr-only">Close Menu</span>
      </label>

      <!-- Mobile Navigation -->
      <div class="drawer-side mt-0 p-md h-full flex justify-center content-center items-center">
        <ul class="menu p-4 w-80 bg-base-100 text-base-content m-auto">
          @if (has_nav_menu('primary_navigation'))
            <nav class="main-nav drawer-side text-darkGrey-500 hover:text-primary" role="navigation" aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}">
              {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav', 'echo' => false]) !!}
            </nav>
          @endif
        </ul>
      </div>
    </div>

    <!-- Logo -->
    <div class="navbar-start w-auto h-full">
      <a class="brand w-auto h-full block" href="{{ home_url('/') }}">
        <figure class="block w-auto h-full max-h-full">
          {!! $siteBrand !!}
        </figure>
      </a>
    </div>
    <!-- Main Navigation Container -->
    <div class="nav-container desktop-nav navbar-end flex-auto flex-nowrap">
      <!-- Desktop navigation -->
        @if (has_nav_menu('primary_navigation'))
          <nav class="main-nav navigation max-md:hidden !text-primaryWhite" role="navigation" aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}">
            {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav', 'echo' => false]) !!}
          </nav>
        @endif
    </div>

    <!-- Mobile Nav Toggle -->
    <div role="button" class="drawer-button navbar-end md:hidden w-auto ml-10 mr-1" aria-labelledby="nav-toggle-label" @click="$store.global.showNav = !$store.global.showNav">
      <i class="fa fa-bars text-4xl"></i>
      <span class="sr-only" id="nav-toggle-label">Open Mobile Menu</span>
    </div>

    <!-- Search Modal -->
    <input type="checkbox" class="modal-toggle" id="search-modal-toggle" aria-hidden="true" x-ref="searchModalToggle" />
    <div class="search__modal modal bg-white/[.925]" id="search-modal">
      <label class="font-bold text-base hover:text-primary mx-10 absolute top-10 right-10 w-10 h-10" for="search-modal-toggle" role="button" aria-controls="search-modal-toggle" aria-label="Hide search form" tabindex="0" @click.prevent="$refs.searchModalToggle.checked = ! $refs.searchModalToggle.checked">
                    <span class="sr-only">
                        Hide search form
                    </span>
        <i class="fa-solid fa-xmark-large select-none before:font-bold before:content-['\e59b']" aria-hidden="true" role="presentation"></i>
      </label>
      <div class="modal-box bg-transparent shadow-none lg:max-w-[70vw]">
        <div class="modal-content">
          <form method="get" action="/" class="search__form flex flex-nowrap justify-around">
            <input type="text" class="search__input text-xl md:text-[3.7vw] xl:text-5xl mr-5 w-full border-2 border-base bg-white/70" placeholder="Search for..." name="s" />
            <button class="search__submit px-10 py-0 text-xl md:text-4xl hover:text-primary"><i class="fa-regular fa-magnifying-glass before:font-bold before:content-['\f002']"></i></button>
          </form>
        </div>
      </div>
    </div>
  </section>
</header>
