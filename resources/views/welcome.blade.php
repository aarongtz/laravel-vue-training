@extends('layouts.app')

@section('content')
<div class="container" style="">

    <form action="{{ route('home') }}" method="get">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="">Search by Name</label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ $name }}">
                </div>
                <div>
                    <button class="btn btn-info" type="submit">
                        Search
                    </button>
                    <br><br>
                </div>
            </div>
        </div>
    </form>
    
    <div class="row">
        @foreach($videos as $video)
        <div class="col-sm-4">
            <div class="card mb-3 ml-2" style="">
                <a href="{{ route('videos.show', ['video'=> $video]) }}">

                    <img style="width:100%;height: 230px; object-fit: cover;" class="card-img-top" src='{{ asset(Storage::url("thumbnail/{$video->id}.png")) }}' alt="Card image cap">
                </a>
                <div class="card-body">
                    <h5 class="card-title">{{$video->title}}</h5>
                    <p class="card-text">{{$video->description}}</p>
                    <small class="text-muted"> Uploaded By <a href="{{route('channels.show', ['channel'=>$video->channel])}}">{{$video->channel->name}}</a></small>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection