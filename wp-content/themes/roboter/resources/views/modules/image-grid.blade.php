<section class="image-grid grid-container">
  <div class="grid-x grid-margin-y grid-margin-x">
  @foreach($fields->images as $image)
    @if($loop->iteration == 1 || $loop->iteration == 7)
      <div class="cell auto">
        <div class="grid-x grid-margin-x grid-margin-y">
    @elseif($loop->iteration == 5 || $loop->iteration == 6)
      <div class="cell align-self-stretch {{ $loop->last && $loop->iteration == 6 ? 'small-12' : 'large-6' }}">
    @endif

          <div class="image-grid-item {{ $loop->iteration < 5 || $loop->iteration > 6 ? 'cell medium-6' : 'single' }}" style="background:url('{!! esc_url_raw($image->image->sizes->large) !!}')" data-index="{{ $loop->index }}">
            <figure class="show-for-sr">
              <img src="{!! esc_url_raw($image->image->sizes->large) !!}" alt="{{ $image->image->alt }}" />
            </figure>
          </div>

    @if($loop->iteration == 4 || ($loop->iteration > 6 && $loop->last))
        </div>
      </div>
    @elseif($loop->iteration == 5 || $loop->iteration == 6)
      </div>
    @endif
  @endforeach
  </div>

  <div class="image-grid__lightbox">
    <div class="grid-container" style="position: relative">
      <button class="lightbox-close-button" aria-label="Close image slideshow" type="button" data-close>
        <span aria-hidden="true">&times;</span>
      </button>
      <p>Look at this close button!</p>
      <div class="image-grid__slider grid-y align-center" role="region" aria-label="Image Gallery" style="position: relative">
        <div class="image-grid__slider-container">
          @foreach($fields->images as $image)
            <div class="image-grid__slider-slide">
              <figure class="image-grid__slider-figure">
                <img class="image-grid__slider-image" src="{!! esc_url_raw($image->image->sizes->large) !!}" alt="{{ $image->image->alt }}" />
                <figcaption class="image-grid__slider-caption">
                <span class="image-slider-subtitle">
                  {!! esc_attr($image->subtitle) !!}
                </span>
                  {!! $image->text !!}
                </figcaption>
              </figure>
            </div>
          @endforeach
        </div>
      </div>
      <div class="image-grid__slider-controls">
        <div class="arrows">
          <button class="image-grid__slide-prev">
            <span class="show-for-sr">Previous Image</span>
            <span aria-hidden="true" >
            <svg width="16px" height="25px" viewBox="0 0 16 25" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="transform:scaleX(-1)">
            <!-- Generator: Sketch 64 (93537) - https://sketch.com -->
            <title>Previous</title>
            <g id="Modules" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <g id="Desktop---Gallery-Lightbox" transform="translate(-1260.000000, -485.000000)">
                    <g id="Lightbox">
                        <g class="chevron-solid" transform="translate(1260.000000, 485.000000)" fill="#000000" fill-rule="nonzero">
                            <path d="M14.7531963,13.4686644 L3.66050228,24.5613014 C3.1255137,25.09629 2.2581621,25.09629 1.72323059,24.5613014 L0.429452055,23.2675228 C-0.104623288,22.7334475 -0.105650685,21.8678653 0.42716895,21.3325342 L9.21832192,12.5 L0.42716895,3.66752283 C-0.105650685,3.13219178 -0.104623288,2.26660959 0.429452055,1.73253425 L1.72323059,0.438755708 C2.25821918,-0.0962328767 3.12557078,-0.0962328767 3.66050228,0.438755708 L14.7531393,11.5313927 C15.2881279,12.0663242 15.2881279,12.9336758 14.7531963,13.4686644 Z" id="Path"></path>
                        </g>
                    </g>
                </g>
            </g>
        </svg>
          </span>
          </button>
          <button class="image-grid__slide-next">
            <span class="show-for-sr">Next Image</span>
            <span aria-hidden="true">
            <svg width="16px" height="25px" viewBox="0 0 16 25" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
              <!-- Generator: Sketch 64 (93537) - https://sketch.com -->
              <title>Next</title>
              <g id="Modules" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                  <g id="Desktop---Gallery-Lightbox" transform="translate(-1260.000000, -485.000000)">
                      <g id="Lightbox">
                          <g class="chevron-solid" transform="translate(1260.000000, 485.000000)" fill="#000000" fill-rule="nonzero">
                              <path d="M14.7531963,13.4686644 L3.66050228,24.5613014 C3.1255137,25.09629 2.2581621,25.09629 1.72323059,24.5613014 L0.429452055,23.2675228 C-0.104623288,22.7334475 -0.105650685,21.8678653 0.42716895,21.3325342 L9.21832192,12.5 L0.42716895,3.66752283 C-0.105650685,3.13219178 -0.104623288,2.26660959 0.429452055,1.73253425 L1.72323059,0.438755708 C2.25821918,-0.0962328767 3.12557078,-0.0962328767 3.66050228,0.438755708 L14.7531393,11.5313927 C15.2881279,12.0663242 15.2881279,12.9336758 14.7531963,13.4686644 Z" id="Path"></path>
                          </g>
                      </g>
                  </g>
              </g>
            </svg>
          </span>
          </button>
        </div>
      </div>
    </div>
  </div>
  </div>
</section>
