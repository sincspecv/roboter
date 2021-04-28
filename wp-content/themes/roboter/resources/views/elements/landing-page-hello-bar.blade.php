<div class="grid-x grid-margin-x align-bottom">
  <div class="cell small-6 medium-auto">
    <a href="tel:{!! $link_phone_number !!}" class="ph-cta text-right">
      <span class="ph-cta__label text-right">{!! $phone_number_cta ? esc_attr($phone_number_cta) : 'Call Today!' !!}</span>
      <span class="ph-cta__number text-right">{!! $display_phone_number !!}</span>
    </a>
  </div>
  <div class="cell medium-6 large-shrink">
    <a href="{!! esc_url_raw($button->url) !!}" target="{!! esc_attr($button->target) !!}" class="button accent rounded">{!! esc_attr($button->title) !!}</a>
  </div>
</div>
