@extends('layouts.showtv')

@section('content')

    <div class="header">
        <div class="tvinfo centered-vert-2">
            <div class="center">
                <div class="title">{{$episode->title}}<br></div>
                <div class="text">
                    {{$episode->season_episode}} | {{$episode->runtime}} minutes<br>
                    {{$episode->release_date}} | {{$episode->age_rating}}<br>
                </div>
            </div>
        </div>

        <div class="watched">
            @if(Auth::check() && !$isMarked)
                {!! Form::open(['action'  =>['TVShowsController@markWatched', $episode->id], 'method' => 'GET']) !!}

                {{Form::hidden('userid', Auth::user()->id)}}
                {{Form::hidden('episodeid', $episode->id)}}
                {{Form::submit('Mark as watched', ['class' => 'btn'])}}
                {!! Form::close() !!}
            @endif

            @if($isMarked)
                <button class="btn">Marked as watched</button>
            @endif
        </div>

    </div>
    <div class="about">
        <h3>Description: </h3>
        <p>{{$episode->description}}</p>
    </div>



@endsection