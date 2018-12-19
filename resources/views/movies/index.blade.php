@extends('layouts.tvindex')


@section('content')

    <h1>Movies</h1>
    @if(count($movies) > 0)
        <div class="custom_container">
            @foreach($movies as $movie)

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
                    </script>
                    <a href="/movies/{{$movie->id}}">
                        <div class="poster-container">
                            <img src="{{ URL::asset('img/movies'.'/'.$movie->img) }}" alt="{{$movie->img}}" class="img-rounded dimmed">
                            <div class="centered title">{{$movie->title}}</div>
                            <div class="centered desc" style="visibility: hidden">
                                {{$movie->title}}<br>
                                {{$movie->year}}<br>
                                <i class="fas fa-star"></i> &nbsp;
                                {{$movie->avg_rating}}
                            </div>
                        </div>
                    </a>
                    {{--<h3>{{$movie->title}}</h3>--}}
                </div>
            @endforeach
        </div>
    @else
        <p>No movies found!</p>
    @endif

@endsection