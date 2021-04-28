@if($social_links)
<ul class="social-links">
  @foreach($social_links as $profile)
    <li class="social-links__item">
      <a href="{!! esc_url_raw($profile->link) !!}" target="_blank">
        <span class="show-for-sr">{{ ucwords($profile->network) }}</span>
        <svg focusable="false"><use xlink:href="#tfr-icon-{{ $profile->network }}"></use></svg>
      </a>
    </li>
    @endforeach
</ul>
@endif
