@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                    <div class="card-header">
                        {{ $Video->title }}
                    </div>
                
                    <div class="card-body">
                        <video
                        id="video"
                        class="video-js vjs-big-play-centered"
                        controls
                        preload="auto"
                        width="640"
                        height="264"
                        poster='{{ asset(Storage::url("thumbnail/{$Video->id}.png")) }}'
                        data-setup="{fluid: true}">
                            <source src='{{asset(Storage::url("videos/{$Video->id}/{$Video->id}.m3u8"))}}' type="application/x-mpegURL" />
                            <p class="vjs-no-js">
                                To view this video please enable JavaScript, and consider upgrading to a
                                web browser that
                            </p>
                        </video>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mt-1">                                
                                <h4 class="mt-3"> {{ $Video->title }}</h4>                       
                            </div>

                            <votes :default_votes='{{ $Video->votes }}' entity_id="{{ $Video->id }}" entity_owner="{{ $Video->channel->user_id }}"> </votes>

                        </div>
                        <hr>

                        <div class="d-flex justify-content-between align-items-center mt-5">
                            <div class="media">
                                <img src="" alt="">
                                <div class="media-body m1-2">
                                    <h5 class="mt-0 mb-0">{{ $Video->channel->name}}</h5>
                                    <span class="small">Published on {{ $Video->created_at->toFormattedDateString()}}</span>
                                </div>
                            </div>
                            <subscribe-button :initialsubscriptions="{{ $Video->channel->subscriptions}}" :channel="{{ $Video->channel }}"></subscribe-button>
                        </div>
                    </div>
            </div>
            <comments :video="{{ $Video }}" :channel="{{ $Video->channel }}"></comments>
        </div>
    </div>
</div>
@endsection

@section('styles')
    <link href="https://vjs.zencdn.net/7.10.2/video-js.css" rel="stylesheet" />
    <style>
        .video-js{
            width: 100% !important;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://vjs.zencdn.net/7.10.2/video.min.js"></script>
    <script>
        window.CURRENT_VIDEO = '{{ $Video->id }}'
    </script>
    <script src='{{ asset("js/player.js") }}'></script>
@endsection
