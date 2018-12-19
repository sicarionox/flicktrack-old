@extends('layouts.showtv')

@section('content')

    <div class="header">
        <img src="{{URL::asset('img/movies'.'/'.$movie->img) }}" alt="{{$movie->img}}" class="img-rounded smol">

        <div class="tvinfo centered-vert">
            <div class="title">{{$movie->title}}</div>
            <div class="text">
                {{$movie->year}}
                | &nbsp; {{$movie->runtime}} minutes<br>
                {{$movie->genre}} &nbsp; | &nbsp; {{$movie->age_rating}}
            </div>
        </div>

        <div class="ratings">
            <div class="numbers">
                <div class="round-border">
                    <div class="rating centered">{{ number_format($movie->imdb_rating, 1, '.', ',') }}</div>
                    <div class="smoltext">IMDB</div>
                </div>

                <div class="round-border">
                    <div class="rating centered">{{ number_format($movie->meta_rating, 0, '.', ',') }}</div>
                    <div class="smoltext">META</div>
                </div>

                <div class="round-border">
                    <div class="rating centered">{{ number_format($rating->avg_rating, 1, '.', ',') }}</div>
                    <div class="smoltext">LOCAL</div>
                </div>
            </div>

            <div class="rate">
                <br><br>Rate this movie:
                @for($i = 0; $i < 10; $i++)
                    <a href="{{route('rateMovie', ['id' => $movie->id, 'rating' => $i+1])}}"> <i class="far fa-star"></i> &nbsp;</a>
                @endfor
            </div>s
        </div>

        <div class="fav2">
            @if(Auth::check() && !$isMarkedWatched)
                {!! Form::open(['action'  =>['MoviesController@markWatched', $movie->id], 'method' => 'GET']) !!}

                {{Form::hidden('userid', Auth::user()->id)}}
                {{Form::hidden('movieid', $movie->id)}}
                {{Form::submit('Mark as watched', ['class' => 'btn'])}}
                {!! Form::close() !!}
            @endif

            @if($isMarkedWatched)
                <button class="btn">Marked as watched</button>
            @endif

            @if(Auth::check() && !$isMarkedFav)
                {!! Form::open(['action'  =>['MoviesController@markFavourite', $movie->id], 'method' => 'GET']) !!}

                {{Form::hidden('userid', Auth::user()->id)}}
                {{Form::hidden('movieid', $movie->id)}}
                {{Form::submit('Mark as favourite', ['class' => 'btn'])}}
                {!! Form::close() !!}
            @endif

            @if($isMarkedFav)
                <button class="btn">Marked as favourite</button>
            @endif
        </div>
    </div>

        <div class="about">
            <h3>Description: </h3>
            <p>{{$movie->description}}</p>
            <h3>Actors:</h3>
            <p>{{ $movie->actors }}</p>
            <h3>Directors: </h3>
            <p>{{$movie->directors}}</p>
        </div>


        <br><br>
        <div class = well>
            <h3> Discussion </h3>
            @if(!Auth::guest())
            <div class="well">
                {!! Form::open(['action' => ['MoviesController@addComment', $movie->id], 'method' => 'POST']) !!}
                    {{Form::hidden('_method', 'GET')}}
                    <div class ="form-group">
                        {{Form::label('title', 'Title')}}
                        {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title'])}}
                    </div>
                    <div class ="form-group">
                        {{Form::label('body', 'Body')}}
                        {{Form::text('body', '', ['class' => 'form-control', 'placeholder' => 'Body'])}}
                    </div>
                    {{Form::hidden('movieid', $movie->id)}}
                    {{Form::submit('Submit', ['class' => 'btn-primary'])}}
                {!! Form::close() !!}
            </div>
            @endif
            @foreach($discussion as $post)
                <div class="well">
                    <h3>{{$post->title}}</h3>
                    Created by {{$post->username}} at {{$post->created_at}}<br>
                    {{$post->body}}<br>

                    @if(!Auth::guest())
                        @if(Auth::user()->id == $post->userid)
                            {!! Form::open(['action' => ['MoviesController@deleteComment', $post->id], 'method' => 'GET', '-class' => 'pull-right']) !!}
                                {{Form::hidden('_method', 'DELETE')}}
                                {{Form::hidden('postid', $post->id)}}
                                {{Form::hidden('movieid', $movie->id)}}
                                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                            {!!Form::close()!!}
                        @endif
                    @endif

                </div>
            @endforeach
        </div>

@endsection