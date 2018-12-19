@extends('layouts.profile')


@section('content')
    <div class="header">
        <div class="centered">
            <div class="tvinfo centered-vert">
                <div class="title">{{$user->name}}</div>

                <div class="text">
                    Member since {{$user->created_at}}<br>
                    {{$epiCount}} episodes | {{$movieCount}} movies
                </div>
            </div>
        </div>

    </div>

    <div class="about">



        <div class="col-md-6">
            <h3>Favourite Movies:</h3>
            @foreach($followedmovies as $movie)
                <div class="col-md-2">
                    <img src="{{URL::asset('img/movies'.'/'.$movie->img) }}" alt="{{$movie->img}}" class="img-rounded smol">
                    <b><a href="{{route('movie', ['id' => $movie->id])}}"> {{$movie->title}} </a> &nbsp;</b>  &nbsp;
                </div>
            @endforeach
        </div>

        <div class="col-md-6">
            <h3>Favourite Shows:</h3>
            @foreach($followedshows as $show)
                <div class="col-md-2">
                    <img src="{{URL::asset('img/tv_shows'.'/'.$show->img) }}" alt="{{$show->img}}" class="img-rounded smol">
                    <b><a href="{{route('tvshow', ['id' => $show->id])}}">{{$show->title}} </a> &nbsp;</b>
                </div>
            @endforeach
        </div>

        <div class="col-md-6">
            <h3>Watched Movies:</h3>
            @foreach($watchedmovies as $movie)
                <div class="col-md-2">
                    <img src="{{URL::asset('img/movies'.'/'.$movie->img) }}" alt="{{$movie->img}}" class="img-rounded smol">
                    <b><a href="{{route('movie', ['id' => $movie->id])}}"> {{$movie->title}} </a> &nbsp;</b>  &nbsp;
                </div>
            @endforeach
        </div>

        <div class="col-md-6">
            <h3>Watched Episodes:</h3>
            @foreach($watchedepisodes as $episode)
                {{$episode->title}} |
            @endforeach
        </div>




    </div>




@endsection