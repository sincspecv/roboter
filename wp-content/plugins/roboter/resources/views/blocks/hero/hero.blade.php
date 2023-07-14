<div class="hero relative {!! $classes !!}"
     id="{!! empty($attributes['anchor']) ? "hero-{$attributes['id']}" : $attributes['anchor'] !!}"
>
    @if($style === 'default')
        <figure class="absolute z-0 w-screen h-full object-cover" style="background-image:url( {!! empty($fields->image) ? get_the_post_thumbnail_url() : $fields->image->sizes->large !!} )">
            <img class="sr-only focus:not-sr-only" src="{!! empty($fields->image) ? get_the_post_thumbnail_url() : $fields->image->sizes->large !!}" alt="{!! empty($fields->image) ? get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ) : $fields->image->alt !!}" />
        </figure>
    @endif

    <div class="hero-content">
        <h1>{!! empty($fields->heading) ? get_the_title() : $fields->heading !!}</h1>
        {!! $fields->text !!}
    </div>
</div>
