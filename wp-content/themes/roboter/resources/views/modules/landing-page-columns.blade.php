<section class="lp-columns {{ $fields->background }}">
  <div class="grid-container grid-padding-x grid-padding-y">
    <div class="grid-x grid-margin-x grid-padding-y">
      <article class="cell medium-10 medium-offset-1 text-center content-container">
        <h2>{!! esc_attr($fields->heading) !!}</h2>
        @if($fields->sub_heading)
        <p class="lead">{!! esc_attr($fields->sub_heading) !!}</p>
        @endif
      </article>
      <div class="cell align-middle">
        <div class="grid-x grid-margin-x grid-margin-y align-center columns-container">
          @foreach($fields->columns as $column)
            <div class="cell medium-{{ ceil(24 / count($fields->columns)) < 7 ? ceil(24 / count($fields->columns)) : '6' }} large-{{ ceil(12 / count($fields->columns)) < 9 ? ceil(12 / count($fields->columns)) : '8' }}">
              @if( $column->link)
              <a href="{!! esc_url_raw($column->link->url) !!}" target="{{ $column->link->target }}" class="card column">
              @else
              <div class="card column">
              @endif
                <div class="card-section column__image" style="background:url('{!! esc_url_raw($column->image->sizes->large) !!}')">
                  <figure class="show-for-sr">
                    <img src="{!! esc_url_raw($column->image->sizes->large) !!}" alt="{!! esc_attr($column->image->alt) !!}" />
                  </figure>
                </div>
                <div class="card-section column__text">
                  <h3>{!! $column->column_heading !!}</h3>
                  {!! $column->text !!}
                </div>
              @if( $column->link)
              </a>
              @else
              </div>
              @endif
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
