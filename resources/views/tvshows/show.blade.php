@extends('layouts.showtv')

@section('content')

    <div class="header">
        <img src="{{URL::asset('img/tv_shows'.'/'.$show->img) }}" alt="{{$show->img}}" class="img-rounded smol">

        <div class="tvinfo centered-vert">
            <div class="title">{{$show->title}}</div>
                <div class="text">
                    {{$show->start_year}}-
                    @if($show->end_year == 0)
                        &nbsp;
                    @else
                        {{$show->end_year}}
                    @endif
                     | &nbsp; {{$show->avg_runtime}} minutes<br>
                    {{$show->genre}} &nbsp; | &nbsp; {{$show->age_rating}}
                </div>
        </div>

        <div class="ratings">
            <div class="numbers">
                <div class="round-border">
                    <div class="rating centered">{{ number_format($show->imdb_rating, 1, '.', ',') }}</div>
                    <div class="smoltext">IMDB</div>
                </div>


                <div class="round-border">
                    <div class="rating centered">{{ number_format($show->meta_rating, 0, '.', ',') }}</div>
                    <div class="smoltext">META</div>
                </div>


                <div class="round-border">
                    <div class="rating centered">{{ number_format($rating->avg_rating, 1, '.', ',') }}</div>
                    <div class="smoltext">LOCAL</div>
                </div>
            </div>

            <div class="rate">
                <br><br>Rate this TV show:
                @for($i = 0; $i < 10; $i++)
                    <a href="{{route('rateEpisode', ['id' => $show->id, 'rating' => $i+1])}}"><i class="far fa-star"></i></a> &nbsp;
                @endfor
            </div>

        </div>

        <div class="fav">
            @if(Auth::check() && !$isMarked)
                {!! Form::open(['action'  =>['TVShowsController@markFavourite', $show->id], 'method' => 'GET']) !!}

                {{Form::hidden('userid', Auth::user()->id)}}
                {{Form::hidden('showid', $show->id)}}
                {{Form::submit('Mark as favourite', ['class' => 'btn'])}}
                {!! Form::close() !!}
            @endif
            @if($isMarked)
                <button class="btn">Marked as favourite</button>
            @endif
        </div>

    </div>


        <div class='about' style= "clear:left;">

            <h3>Description: </h3>
            <p>{{$show->description}}</p>
            <h3> Actors: </h3>
            <p>{{ $show->actors }}</p>
            <h3> Directors: </h3>
            <p>{{$show->creators}}</p>
            <hr>
        </div>

    <div class="episodes">
        <h3>Episodes:</h3><br>
        @foreach($episodes as $episode)
            <div class="col-md-2"><a href="/episodes/{{$episode->id}}">{{$episode->season_episode}}: {{$episode->title}}</a></div>
        @endforeach
    </div>


        <br><br>
        <div class="well">
            <h3> Discussion </h3>
            @if(!Auth::guest())
                <div class="well">
                    {!! Form::open(['action' => ['TVShowsController@addComment', $show->id], 'method' => 'POST']) !!}
                    {{Form::hidden('_method', 'GET')}}
                    <div class ="form-group">
                        {{Form::label('title', 'Title')}}
                        {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title'])}}
                    </div>
                    <div class ="form-group">
                        {{Form::label('body', 'Body')}}
                        {{Form::text('body', '', ['class' => 'form-control', 'placeholder' => 'Body'])}}
                    </div>
                    {{Form::hidden('showid', $show->id)}}
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
                            {!! Form::open(['action' => ['TVShowsController@deleteComment', $post->id], 'method' => 'GET', 'class' => 'pull-right']) !!}
                            {{Form::hidden('_method', 'DELETE')}}
                            {{Form::hidden('postid', $post->id)}}
                            {{Form::hidden('showid', $show->id)}}
                            {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                            {!!Form::close()!!}
                        @endif
                    @endif

                </div>
            @endforeach
        </div>


@endsection
</div>