<section class="global-cta module">
  <div class="grid-container">
    <div class="grid-x grid-margin-x grid-margin-y">
      <div class="cell medium-2 medium-order-2">
        <figure class="global-cta__image">
          <img src="{!! $global_cta->image->sizes->large !!}" alt="{!! $global_cta->image->alt !!}" />
        </figure>
      </div>
      <div class="cell medium-10 medium-order-1 global-cta__content">
        @if($global_cta->heading)
          <h2 class="h3 global-cta__content-heading">{!! $global_cta->heading !!}</h2>
        @endif
        @if($global_cta->subheading)
          <p class="lead global-cta__content-subheading">{!! $global_cta->subheading !!}</p>
        @endif
        @if($global_cta->text)
          <div class="global-cta__content-text">
            {!! $global_cta->text !!}
          </div>
        @endif
        @if($global_cta->button !== false)
          <a href="{!! $global_cta->button->url !!}" target="{!! $global_cta->button->target !!}" class="button primary global-cta__content-button">{!! $global_cta->button->title !!}</a>
        @endif
      </div>
    </div>
  </div>
</section>
