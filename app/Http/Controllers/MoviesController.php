<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Movie;
use App\MovieRating;
use App\WatchedMovie;
use App\FollowedMovie;
use App\MovieDiscussion;

class MoviesController extends Controller
{
    public function index(){
        $results = DB::select('select * from movies inner join movie_ratings where movies.id = movie_ratings.id');
        $movies = Movie::hydrate($results);
        return view('movies.index')->with('movies', $movies);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id){


        $movie = Movie::find($id);
        $rating = MovieRating::find($id);
      //  $discussion = MovieDiscussion::where('movie_id', '=', $id)->orderBy('created_at', 'asc');

        $results = DB::select('SELECT users.name as username, users.id as userid, movie_discussions.id, movie_discussions.title, movie_discussions.body, movie_discussions.created_at, movie_discussions.movie_id 
                               from movie_discussions inner join users on users.id = movie_discussions.user_id where movie_id = '. $id .' order by created_at desc');
        $discussion = MovieDiscussion::hydrate($results);

        if(Auth::user() != null){
            $markedWatched = WatchedMovie::where('movie_id', '=', $id)->where('user_id', '=', Auth::user()->id)->get();
            $markedFav = FollowedMovie::where('movie_id', '=', $id)->where('user_id', '=', Auth::user()->id)->get();
            if($markedWatched->isEmpty())
                $isMarkedWatched = false;
            else $isMarkedWatched = true;
            if($markedFav->isEmpty())
                $isMarkedFav = false;
            else $isMarkedFav = true;
            return view('movies.show')->with('movie', $movie)->with('rating', $rating)->with('isMarkedFav', $isMarkedFav)->with('isMarkedWatched', $isMarkedWatched)->with('discussion', $discussion);
        }

        return view('movies.show')->with('movie', $movie)->with('rating', $rating)->with('isMarkedFav', false)->with('isMarkedWatched', false)->with('discussion', $discussion);
    }

    public function markWatched(Request $request){

        $fav = new WatchedMovie;
        $fav->id = null;
        $fav->movie_id = $request->input('movieid');
        $fav->user_id = $request->input('userid');
        $fav->save();


        $movie = Movie::find($request->input('movieid'));

        return redirect('/movies/'.$request->input('movieid'))->with('movie', $movie)->with('success', 'Movie marked as watched');
    }

    public function markFavourite(Request $request){

        $fav = new FollowedMovie;
        $fav->id = null;
        $fav->movie_id = $request->input('movieid');
        $fav->user_id = $request->input('userid');
        $fav->save();


        $movie = Movie::find($request->input('movieid'));
/*        return redirect('/movies/'.$request->input('movieid '))->with('movie', $movie)->with('success', 'Movie marked as favourite');*/
        return redirect()->action('MoviesController@show', ['id' => $request->input('movieid')])->with('success', 'Movie marked as favourite');
    }


    public function addComment(Request $request){
        $post = new MovieDiscussion;
        $post->id = null;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->movie_id =  $request->input('movieid');
        $post->save();
        return redirect()->action('MoviesController@show', ['id' => $request->input('movieid')])->with('success', 'Comment posted');

    }
    public function deleteComment(Request $request){
        $id = $request->input('postid');
        $movieid = $request->input('movieid');
        $comment = MovieDiscussion::find($id);
        if(auth()->user()->id != $comment->user_id){
            //return redirect('/movie/'.$movieid)->with('error', 'Unauthorized Page');
            return redirect()->action('MoviesController@show', ['id' => $movieid])->with('error', 'Unauthorized Page');
        }
        $comment->delete();
        return redirect()->action('MoviesController@show', ['id' => $movieid])->with('success', 'Comment deleted');
    }

    public function rate($id, $rating){
        $rat = MovieRating::find($id);
        $avg = $rat->avg_rating;
        $number = $rat->number_of_ratings;
        $newavg = (($avg*$number)+$rating)/($number+1);

        $rat->avg_rating = $newavg;
        $rat->number_of_ratings = $number+1;
        $rat->save();

        return redirect()->action('MoviesController@show', ['id' => $id])->with('success', 'Rated successfully');
    }
}
