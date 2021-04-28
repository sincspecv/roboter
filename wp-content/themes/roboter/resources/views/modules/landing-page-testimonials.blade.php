<section class="lp-testimonials {{ $fields->background }}">
  <div class="grid-container grid-padding-x grid-padding-y">
    <div class="grid-x grid-margin-x grid-padding-y">
      <article class="cell medium-10 medium-offset-1 text-center content-container">
        <h2>{!! esc_attr($fields->heading) !!}</h2>
        @if($fields->sub_heading)
        <p class="lead">{!! esc_attr($fields->sub_heading) !!}</p>
        @endif
        @if($fields->text)
          {!! $fields->text !!}
        @endif
      </article>
      <div class="cell align-middle text-center">
        <div class="grid-x grid-margin-x grid-margin-y align-center testimonials-container">
          @foreach($fields->testimonials as $testimonial)
            <div class="cell {{ count($fields->testimonials) > 1 ? 'medium-4' : 'medium-7' }}">
              <div class="card testimonial">
                <div class="card-section testimonial__quote">
                  <span class="testimonial__quote-icon">
                    <svg width="47px" height="42px" viewBox="0 0 47 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <defs>
                            <rect id="path-1" x="0" y="19" width="750" height="293" rx="13"></rect>
                            <filter x="-1.5%" y="-3.2%" width="103.1%" height="107.8%" filterUnits="objectBoundingBox" id="filter-2">
                                <feOffset dx="0" dy="2" in="SourceAlpha" result="shadowOffsetOuter1"></feOffset>
                                <feGaussianBlur stdDeviation="3.5" in="shadowOffsetOuter1" result="shadowBlurOuter1"></feGaussianBlur>
                                <feColorMatrix values="0 0 0 0 0   0 0 0 0 0   0 0 0 0 0  0 0 0 0.3 0" type="matrix" in="shadowBlurOuter1"></feColorMatrix>
                            </filter>
                        </defs>
                        <g id="Symbols" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g id="components/testimonial-light-wide" transform="translate(-352.000000, -27.000000)">
                                <g id="quote-left-solid-copy-5" transform="translate(352.000000, 27.000000)" fill="#000000" fill-rule="nonzero">
                                    <path d="M42.59375,20.6391304 L35.25,20.6391304 L35.25,14.7819876 C35.25,11.5514072 37.8845703,8.92484472 41.125,8.92484472
                                    L41.859375,8.92484472 C43.0802734,8.92484472 44.0625,7.94560365 44.0625,6.72841615 L44.0625,2.33555901 C44.0625,1.11837151
                                    43.0802734,0.139130435 41.859375,0.139130435 L41.125,0.139130435 C33.0101563,0.139130435 26.4375,6.69180901 26.4375,14.7819876
                                    L26.4375,36.7462733 C26.4375,39.1714965 28.4111328,41.1391304 30.84375,41.1391304 L42.59375,41.1391304 C45.0263672,41.1391304
                                    47,39.1714965 47,36.7462733 L47,25.0319876 C47,22.6067644 45.0263672,20.6391304 42.59375,20.6391304 Z M16.15625,20.6391304
                                    L8.8125,20.6391304 L8.8125,14.7819876 C8.8125,11.5514072 11.4470703,8.92484472 14.6875,8.92484472 L15.421875,8.92484472
                                    C16.6427734,8.92484472 17.625,7.94560365 17.625,6.72841615 L17.625,2.33555901 C17.625,1.11837151 16.6427734,0.139130435
                                    15.421875,0.139130435 L14.6875,0.139130435 C6.57265625,0.139130435 0,6.69180901 0,14.7819876 L0,36.7462733 C0,39.1714965
                                    1.97363281,41.1391304 4.40625,41.1391304 L16.15625,41.1391304 C18.5888672,41.1391304 20.5625,39.1714965 20.5625,36.7462733
                                    L20.5625,25.0319876 C20.5625,22.6067644 18.5888672,20.6391304 16.15625,20.6391304 Z" id="Shape"></path>
                                </g>
                            </g>
                        </g>
                    </svg>
                  </span>
                </div>
                <div class="card-section testimonial__text">
                  {!! App::getTestimonial($testimonial->ID)->text !!}
                </div>
                <div class="card-section testimonial__attribution">
                  <span class="testimonial__attribution-name">
                    {!! App::getTestimonial($testimonial->ID)->name !!}
                  </span>
                  <span class="testimonial__attribution-org">
                    {!! App::getTestimonial($testimonial->ID)->org !!}
                  </span>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
      @if($fields->button)
      <div class="cell text-center button-container">
        <a href="{!! esc_url_raw($fields->button->url) !!}" target="{!! esc_attr($fields->button->target) !!}" class="button accent rounded">{!! esc_attr($fields->button->title) !!}</a>
      </div>
      @endif
    </div>
  </div>
</section>
