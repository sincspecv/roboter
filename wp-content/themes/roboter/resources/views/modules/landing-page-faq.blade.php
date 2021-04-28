<section class="lp-faq grid-x {{ $fields->background }}">
  <div class="grid-container grid-padding-x grid-padding-y" style="width:100%">
    <div class="grid-x align-center">
      <article class="cell medium-10 content-container">
        <h2>{!! esc_attr($fields->heading) !!}</h2>
        @if($fields->sub_heading)
          <p class="lead">{!! esc_attr($fields->sub_heading) !!}</p>
        @endif

        <ul class="faq-list accordion" data-accordion data-allow-all-closed="true" role="tablist">
          @foreach($fields->faqs as $faq)
            <li class="accordion-item" data-accordion-item>
              <a href="#" class="accordion-title"><h3>{!! esc_attr($faq->faq_heading) !!}</h3></a>
              <div class="accordion-content" data-tab-content>
                {!! $faq->faq_text !!}
              </div>
            </li>
          @endforeach
        </ul>

        @if($fields->button)
          <div class="button-container">
            <a href="{!! esc_url_raw($fields->button->url) !!}" target="{!! esc_attr($fields->button->target) !!}" class="button accent rounded">{!! esc_attr($fields->button->title) !!}</a>
          </div>
        @endif

      </article>
    </div>
  </div>

  <!-- FAQ SCHEMA -->
  <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "FAQPage",
      "mainEntity": [
      @foreach($fields->faqs as $faq)
        {
          "@type": "Question",
          "name": "{!! esc_attr($faq->faq_heading) !!}",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "{!! strip_tags($faq->faq_text) !!}"
          }
        }
        @endforeach
      ]
    }
  </script>
  <!-- END FAQ SCHEMA -->
</section>
