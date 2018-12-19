<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\TVShow;
use App\Episodes;
use App\FollowedShow;
use App\WatchedEpisodes;
use App\User;
use App\TVShowDiscussion;
use App\TVRating;

class TVShowsController extends Controller
{
    public function index(){

       // $ratings = TVRating::all();
        $results = DB::select('select * from tv_shows inner join ratings_tv where tv_shows.id = ratings_tv.id');
        $tvshows = TVShow::hydrate($results);
        return view('tvshows.index')->with('tvshows', $tvshows);
    }

    public function searchShow(Request $request){
        var_dump($request->all());
        $searchQuery = $request->input('showname');
        $results = DB::select('select * from tv_shows where tv_shows.title like %'.$searchQuery.'%');
        $tvshows = TVShow::hydrate($results);
        return view('tvshows.index')->with('tvshows', $tvshows);
    }

    public function show($id)
    {

        $show = TVShow::find($id);
        $episodes = Episodes::where('tv_show_id', '=', $id)->orderBy('episode_number', 'asc')->get();
        $rating = TVRating::find($id);

        $results = DB::select('SELECT users.name as username, users.id as userid, tv_show_discussions.id, tv_show_discussions.title, tv_show_discussions.body, tv_show_discussions.created_at, tv_show_discussions.show_id 
                               from tv_show_discussions inner join users on users.id = tv_show_discussions.user_id where show_id = '. $id .' order by created_at desc');
        $discussion = TVShowDiscussion::hydrate($results);

        if(Auth::user() != null){
            $user = User::find(Auth::user()->id);
            $marked = FollowedShow::where('show_id', '=', $id)->where('user_id', '=', Auth::user()->id)->get();
            if($marked->isEmpty())
                $isMarked = false;
            else $isMarked = true;
            return view('tvshows.show')->with('show', $show)->with('episodes', $episodes)->with('isMarked', $isMarked)->with('discussion', $discussion)->with('rating', $rating);
        }
        return view('tvshows.show')->with('show', $show)->with('episodes', $episodes)->with('isMarked', false)->with('discussion', $discussion)->with('rating', $rating);

    }

    public function showEpisode($id){
        $episode = Episodes::find($id);
        if(Auth::user() != null){
            $user = User::find(Auth::user()->id);
            $marked = WatchedEpisodes::where('episode_id', '=', $id)->where('user_id', '=', Auth::user()->id)->get();

            if($marked->isEmpty()) $isMarked = false;
            else $isMarked = true;
            return view('tvshows.showepisode')->with('episode', $episode)->with('user', $user)->with('isMarked', $isMarked);
        }


        return view('tvshows.showepisode')->with('episode', $episode)->with('isMarked', false);

    }

    public function markWatched(Request $request){

        $fav = new WatchedEpisodes;
        $fav->id = null;
        $fav->episode_id = $request->input('episodeid');
        $fav->user_id = $request->input('userid');
        $fav->save();


        $episode = Episodes::find($request->input('episodeid'));

        return redirect('/episodes/'.$request->input('episodeid'))->with('episode', $episode)->with('success', 'Episode marked as watched');
    }

    public function markFavourite(Request $request){

        $fav = new FollowedShow;
        $fav->id = null;
        $fav->show_id = $request->input('showid');

        $fav->user_id = $request->input('userid');
        $fav->save();

        $show = TVShow::find($request->input('showid'));
        $episodes = Episodes::where('tv_show_id', '=', $request->input('showid'))->orderBy('episode_number', 'asc')->get();

        return redirect('/tvshows/'.$request->input('showid'))->with('show', $show)->with('episodes', $episodes)->with('success', 'Show marked as favourite');
    }

    public function addComment(Request $request){
    $post = new TVShowDiscussion;
    $post->id = null;
    $post->title = $request->input('title');
    $post->body = $request->input('body');
    $post->user_id = auth()->user()->id;

    $post->show_id =  $request->input('showid');
    $post->save();
    return redirect()->action('TVShowsController@show', ['id' => $request->input('showid')])->with('success', 'Comment posted');

}

    public function deleteComment(Request $request){
        $id = $request->input('postid');
        $showid = $request->input('showid');
        $comment = TVShowDiscussion::find($id);
        if(auth()->user()->id != $comment->user_id){
            //return redirect('/movie/'.$movieid)->with('error', 'Unauthorized Page');
            return redirect()->action('TVShowsController@show', ['id' => $showid])->with('error', 'Unauthorized Page');
        }
        $comment->delete();
        return redirect()->action('TVShowsController@show', ['id' => $showid])->with('success', 'Comment deleted');
    }

    public function rate($id, $rating){
        $rat = TVRating::find($id);
        $avg = $rat->avg_rating;
        $number = $rat->number_of_ratings;
        $newavg = (($avg*$number)+$rating)/($number+1);

        $rat->avg_rating = $newavg;
        $rat->number_of_ratings = $number+1;
        $rat->save();

        return redirect()->action('TVShowsController@show', ['id' => $id])->with('success', 'Rated successfully');
    }

}
