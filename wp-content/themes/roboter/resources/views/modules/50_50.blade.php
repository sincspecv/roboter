<section class="fifty-fifty">
  @foreach($fields->rows as $row)
    <div class="grid-x grid-padding-y grid-padding-x align-middle">
      <div class="cell medium-6 {{ $row->left_block->left_background }} {{ $loop->index % 2 == 0 ? 'small-order-2 medium-order-1' : '' }}">
        @if($row->left_block->left_background == 'image')
          <div class="row__image" style="background-image: url('{{ $row->left_block->left_image->sizes->large }}')">
            <figure class="image-container show-for-sr">
              <img src="{{ $row->left_block->left_image->sizes->large }}" srcset="{{ wp_get_attachment_image_srcset( $row->left_block->left_image->id ) }}" alt="{!! esc_attr( $row->left_block->left_image->alt ) !!}" />
            </figure>
          </div>
        @else
          <article class="row__content-container">
            <h2>{!! esc_attr($row->left_block->left_heading) !!}</h2>
            {!! $row->left_block->left_text !!}
            @if($row->left_block->left_button)
              <a href="{!! esc_url_raw($row->left_block->left_button->url) !!}" target="{!! esc_attr($row->left_block->left_button->target) !!}" class="button accent rounded">{!! esc_attr($row->left_block->left_button->title) !!}</a>
            @endif
          </article>
        @endif
      </div>
      <div class="cell medium-6 {{ $row->right_block->right_background }} {{ $loop->index % 2 == 0 ? 'small-order-1 medium-order-2' : '' }}">
        @if($row->right_block->right_background == 'image')
          <div class="row__image" style="background-image: url('{{ $row->right_block->right_image->sizes->large }}')">
            <figure class="image-container show-for-sr">
              <img src="{{ $row->right_block->right_image->sizes->large }}" srcset="{{ wp_get_attachment_image_srcset( $row->right_block->right_image->id ) }}" alt="{!! esc_attr( $row->right_block->right_image->alt ) !!}" />
            </figure>
          </div>
        @else
          <article class="row__content-container">
            <h2>{!! esc_attr($row->right_block->right_heading) !!}</h2>
            {!! $row->right_block->right_text !!}
            @if($row->right_block->right_button)
              <a href="{!! esc_url_raw($row->right_block->right_button->url) !!}" target="{!! esc_attr($row->right_block->right_button->target) !!}" class="button accent rounded">{!! esc_attr($row->right_block->right_button->title) !!}</a>
            @endif
          </article>
        @endif
      </div>
    </div>
  @endforeach
</section>
