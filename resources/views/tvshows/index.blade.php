@extends('layouts.tvindex')


@section('content')
    <h1>TV Shows</h1>
    {{--<form action="" class="search-bar" method="get">--}}
        {{--<input type="text" placeholder="Search for TV Shows..." name="showname" id="searchshow">--}}
        {{--<a href="#">Search</a>--}}
        {{--<button type="submit"><i class="fa fa-search"></i></button>--}}
    {{--</form>--}}

    {!! Form::open(['action' => 'TVShowsController@searchShow', 'method' => 'GET']) !!}
    {{Form::text('showName')}}
    {{Form::submit('Search', ['class' => 'btn'])}}
    {!! Form::close() !!}

    @if(count($tvshows) > 0)
        <div class="custom_container">
            @foreach($tvshows as $tvshow)
                <div class="col-md-2">

                    <script>
                        $(document).ready(function(){
                            $("img.img-rounded.dimmed").hover(function(){
                                $(this).css("filter", "brightness(30%)");
                                $(this).parent().find(".centered.desc").css("visibility", "visible");
                                $(this).parent().find(".centered.title").css("visibility", "hidden");
                            }, function(){
                                $(this).css("filter","brightness(60%)");
                                $(this).parent().find(".centered.desc").css("visibility", "hidden");
                                $(this).parent().find(".centered.title").css("visibility", "visible");
                            });
                        });

                        a.on('click', function(e){
                            console.log("meow");
                            e.preventdefault();
                            variables= $('#searchshow').val();
                            url='/tvshows/search' + variables;
                        })
                    </script>
                    <a href="/tvshows/{{$tvshow->id}}">
                        <div class="poster-container">
                            <img src="{{ URL::asset('img/tv_shows'.'/'.$tvshow->img) }}" alt="{{$tvshow->img}}" class="img-rounded dimmed">
                            <div class="centered title">{{$tvshow->title}}</div>
                            <div class="centered desc" style="visibility: hidden">
                                {{$tvshow->title}}<br>
                                {{$tvshow->start_year}}<br>
                                <i class="fas fa-star"></i> &nbsp;
                                {{$tvshow->avg_rating}}
                            </div>
                        </div>
                    </a>
                    {{--<h3>{{$tvshow->title}}</h3>--}}
                </div>
            @endforeach
        </div>
    @else
        <p>No TV Shows found!</p>
    @endif
@endsection
