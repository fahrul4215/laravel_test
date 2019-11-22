@extends('base')

@section('css')
<style>
    * { box-sizing: border-box; }

    /* force scrollbar */
    html { overflow-y: scroll; }

    body { font-family: sans-serif; }

    /* ---- grid ---- */

    .grid {
        background: #DDD;
    }

    /* clear fix */
    .grid:after {
        content: '';
        display: block;
        clear: both;
    }

    /* ---- .grid-item ---- */

    .grid-sizer,
    .grid-item {
        width: 33.333%;
    }

    .grid-item {
        float: left;
    }

    .grid-item img {
        display: block;
        max-width: 100%;
    }

    .mfp-with-zoom .mfp-container,
    .mfp-with-zoom.mfp-bg {
        opacity: 0;
        -webkit-backface-visibility: hidden;
        /* ideally, transition speed should match zoom duration */
        -webkit-transition: all 0.3s ease-out;
        -moz-transition: all 0.3s ease-out;
        -o-transition: all 0.3s ease-out;
        transition: all 0.3s ease-out;
    }

    .mfp-with-zoom.mfp-ready .mfp-container {
        opacity: 1;
    }
    .mfp-with-zoom.mfp-ready.mfp-bg {
        opacity: 0.8;
    }

    .mfp-with-zoom.mfp-removing .mfp-container,
    .mfp-with-zoom.mfp-removing.mfp-bg {
        opacity: 0;
    }
</style>
<!-- Magnific Popup core CSS file -->
<link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
@endsection

@section('js')
<!-- Magnific Popup core JS file -->
<script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
{{-- masonry layout --}}
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
<script>
    // external js: masonry.pkgd.js, imagesloaded.pkgd.js

    // init Masonry
    var $grid = $('.grid').masonry({
        itemSelector: '.grid-item',
        percentPosition: true,
        columnWidth: '.grid-sizer'
    });
    // layout Masonry after each image loads
    $grid.imagesLoaded().progress( function() {
        $grid.masonry();
    });

    $(document).ready(function() {
        // Initialize popup as usual
        $('.image-link').magnificPopup({
            type: 'image',
            mainClass: 'mfp-with-zoom', // this class is for CSS animation below

            zoom: {
                enabled: true, // By default it's false, so don't forget to enable it

                duration: 300, // duration of the effect, in milliseconds
                easing: 'ease-in-out', // CSS transition easing function

                // The "opener" function should return the element from which popup will be zoomed in
                // and to which popup will be scaled down
                // By defailt it looks for an image tag:
                opener: function(openerElement) {
                    // openerElement is the element on which popup was initialized, in this case its <a> tag
                        // you don't need to add "opener" option if this code matches your needs, it's defailt one.
                        return openerElement.is('img') ? openerElement : openerElement.find('img');
                    }
                }

            });
        });
    </script>
    @endsection

    @section('content')
    <h1>Masonry - imagesLoaded progress</h1>

    <div class="grid">
        <div class="grid-sizer"></div>
        @foreach ($dataImage as $item)
        @if ($item->image != '')
        <div class="grid-item">
            <a href="{{ asset('images/'.$item->image) }}" class="image-link">
                <img src="{{ asset('images/'.$item->image) }}" />
            </a>
        </div>
        @endif
        @endforeach
    </div>
    @endsection
