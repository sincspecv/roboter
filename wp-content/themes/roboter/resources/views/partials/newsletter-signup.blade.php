<aside class="footer-signup" style="background-image:url({!! $footer->background_image->url !!});background-size:cover;background-position: center center">
  <div class="grid-container">
    <div class="grid-x grid-margin-x grid-margin-y align-center-middle">
      <div class="cell medium-8 footer-signup__wrap">
        @if($footer->image)
          <figure class="footer-signup__image">
            {!! $footer->image !!}
          </figure>
        @endif
        <div class="footer-signup__form-wrap">
          @if($footer->form_title)
            <p class="footer-signup__title">
              {!! $footer->form_title !!}
            </p>
          @endif
          @if($footer->form)
            <div class="footer-signup__form">
              {!! App::getGFForm($footer->form) !!}
            </div>
          @endif
        </div>
    </div>
  </div>
</aside>
