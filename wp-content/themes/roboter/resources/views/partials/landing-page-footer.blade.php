<footer class="lp-footer content-info" id="colophon">
  <div class="grid-container">
    <div class="grid-x grid-padding-y grid-padding-x">
      <div class="cell medium-6 large-5 medium-order-2">
        @if($right_column == 'form')
          <div class="lp-footer__form">
            <h3 class="h2">{!! esc_attr($footer_form_title) !!}</h3>
            {!! App::getGFForm($footer_form) !!}
          </div>
        @elseif($right_column == 'image')
          <div class="lp-footer__image">
            <figure>
              <img src="{!! esc_url_raw($footer_image->sizes->large) !!}" alt="{!! esc_attr($footer_image->alt) !!}"
            </figure>
          </div>
        @endif
      </div>
      <div class="cell medium-6 large-7 medium-order-1 location-info">
        <a href="tel:{!! \App\Theme\Util::formatPhone($footer_phone, 'link') !!}" target="_blank" class="lp-footer__phone">{!! \App\Theme\Util::formatPhone($footer_phone, 'display') !!}</a>
        <span class="lp-footer__location-name">{!! esc_attr($footer_location_name) !!}</span>
        @if($footer_address)
          <div class="lp-footer__address">
            {!! $footer_address !!}
          </div>
        @endif
        @if($footer_hours)
          <div class="lp-footer__hours">
            <span class="lp-footer__hours-label">Hours:</span>
            {!! $footer_hours !!}
          </div>
        @endif
        <span class="lp-footer__copyright align-self-bottom">
          &copy; {{ date("Y") }} {!! get_bloginfo('name') !!}
        </span>
      </div>
    </div>
  </div>
</footer>
