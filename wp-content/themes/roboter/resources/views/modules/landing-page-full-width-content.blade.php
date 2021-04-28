<section class="lp-full-width {{ $fields->background }} {{ $fields->form != 0 ? 'has-form' : '' }}">
  <div class="grid-container grid-padding-x grid-padding-y {{ $fields->form == 0 ? 'align-self-middle' : '' }}">
    <div class="grid-x grid-margin-x grid-padding-y">
      <article class="cell {{ $fields->form != 0 ? 'medium-6' : 'medium-10 medium-offset-1 align-self-middle' }} content-container">
        <h2>{!! esc_attr($fields->heading) !!}</h2>
        @if($fields->sub_heading)
        <p class="lead">{!! esc_attr($fields->sub_heading) !!}</p>
        @endif
        {!! $fields->text !!}
        @if($fields->cta_title)
        <span class="cta-title">{!! esc_attr($fields->cta_title) !!}</span>
        @endif
        @if($fields->button)
        <a href="{!! esc_url_raw($fields->button->url) !!}" target="{!! esc_attr($fields->button->target) !!}" class="button accent rounded">{!! esc_attr($fields->button->title) !!}</a>
        @endif
      </article>
      @if($fields->form != 0)
        <div class="cell medium-6 large-5 large-offset-1 form-container">
          <h3 class="h2">{!! esc_attr($fields->form_title) !!}</h3>
          {!! App::getGFForm($fields->form) !!}
        </div>
      @endif
    </div>
  </div>
</section>
