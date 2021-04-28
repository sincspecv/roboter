<!doctype html>
<html {!! get_language_attributes() !!}>
  @include('partials.head')
  <body @php body_class() @endphp>
    @php do_action('wp_body_open') @endphp
    @php do_action('get_header') @endphp
    @include('partials.landing-page-header')
    <div class="wrap container" role="document">
      <div class="content">
        <main class="main" id="main">
          @yield('content')
        </main>
      </div>
    </div>
    @php do_action('get_footer') @endphp
    @include('partials.landing-page-footer')
    @php wp_footer() @endphp
  </body>
</html>
