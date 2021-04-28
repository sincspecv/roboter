{{--
  Template Name: Landing Page
--}}

@extends('layouts.landing-page')

@section('content')
  @while(have_posts()) @php the_post() @endphp
  @include('partials.landing-page-modules')
  @endwhile
@endsection
