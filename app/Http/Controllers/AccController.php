<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\WatchedEpisodes;
use App\FollowedShow;
use App\Episodes;
use App\Movie;
use App\TVShow;
use App\User;

class AccController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function profile($id){
        $title = "Profile";

        $results = DB::select('select * from (episodes inner join watched_episodes on episodes.id = watched_episodes.episode_id) where user_id = ' . $id);
        $watchedepisodes = Episodes::hydrate($results);
        $epiCount = $watchedepisodes->count();

        $results = DB::select('select * from (tv_shows inner join followed_shows on tv_shows.id = followed_shows.show_id) where user_id = ' . $id);
        $followedshows = TvShow::hydrate($results);


        $results =DB::select('select * from (movies inner join followed_movies on  movies.id = followed_movies.movie_id) where user_id = ' . $id);
        $followedmovies = Movie::hydrate($results);

        $results = DB::select('select * from (movies inner join watched_movies on movies.id = watched_movies.movie_id) where user_id = ' . $id);
        $watchedmovies = Movie::hydrate($results);
        $movieCount = $watchedmovies->count();

        $user = User::find($id);

        return view('acc.profile')->with('user', $user)->with('watchedepisodes', $watchedepisodes)->with('followedshows', $followedshows)->with('followedmovies', $followedmovies)->with('watchedmovies', $watchedmovies)->with('epiCount', $epiCount)->with('movieCount', $movieCount);


    }

    public function showsettings(){
        return view('acc.accsettings');
    }

    public function changePassword(Request $request){

        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        return redirect()->back()->with("success","Password changed successfully!");

    }




}
