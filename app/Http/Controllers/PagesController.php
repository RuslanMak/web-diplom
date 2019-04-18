<?php

namespace App\Http\Controllers;

use DB;
use App\Connection;
use Illuminate\Http\Request;
use App\Movie;
use App\Hall;
use App\Place;

class PagesController extends Controller
{
//    //    проверку на аудентыфикацию добавил в web.php
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    public function home() {
      return view('welcome');
    }

    public function controller() {
      return view('controller');
    }

    public function about() {
      $movies = Movie::all();
      $timesOfMovie = Connection::all();
      $hall = Hall::all();
    //      return $movies;

    //      return view('about', compact('movies'), compact('timesOfMovie'), compact('hall'));
      return view('about')
          ->with('movies', $movies)
          ->with('timesOfMovie', $timesOfMovie)
          ->with('hall', $hall);
    }

    public function client() {
      $movies = Movie::all();
      $timesOfMovie = Connection::all();
      $halls = Hall::all();

    //      return view('client.index', compact('movies'), compact('timesOfMovie'), compact('hall'));
      return view('client.index')
          ->with('movies', $movies)
          ->with('timesOfMovie', $timesOfMovie)
          ->with('halls', $halls);
    }

    public function payment($id) {
      if ( !isset(request()->user()->id) ) {
          return redirect('/');
      }

      $userId = request()->user()->id;
      $connect = Connection::find($id);
      $movie = Movie::find($connect->id_movie)->name;
      $hallName = Hall::find($connect->id_hall)->hall_name;
      $startTime = $connect->start_time;

      $places = Place::where('id_connections', '=', $id)
          ->where('id_user', '=', $userId)->get();

//      dd($places);
      $totalPrice = 0;
      foreach ($places as $place) {
          $totalPrice = $totalPrice + $place->price;
      }

      return view('client.payment')
          ->with('movie', $movie)
          ->with('hallName', $hallName)
          ->with('startTime', $startTime)
          ->with('totalPrice', $totalPrice)
          ->with('places', $places)
          ->with('connectionid', $id);
    }

    public function ticket($id) {
      if ( !isset(request()->user()->id) ) {
          return redirect('/');
      }

      $userId = request()->user()->id;
      $connect = Connection::find($id);
      $movie = Movie::find($connect->id_movie)->name;
      $hallName = Hall::find($connect->id_hall)->hall_name;
      $startTime = $connect->start_time;

      $places = Place::where('id_connections', '=', $id)
          ->where('id_user', '=', $userId)->get();

      foreach ($places as $place) {
          if ($place->status == 'selected') {
              $place->status = 'taken';
              $place->save();
          }
      }

      $ticketInfor = [
          'movie' => $movie,
          'startTime' => $startTime,
          'places' => $places,
          'hallName' => $hallName
      ];

      return view('client.ticket')
          ->with('movie', $movie)
          ->with('hallName', $hallName)
          ->with('startTime', $startTime)
          ->with('places', $places)
          ->with('connectionid', $id)
          ->with('ticketInfor', $ticketInfor);
    }

    public function getTimesAndMore() {

      $date = date('Y-m-d h:i:s', time());
      return Connection::where('start_time', '>=', $date)->orderBy('start_time')->get();
    }

    public function getDataOfDate($date) {
        return DB::table('connections')
            ->join('halls', 'connections.id_hall', '=', 'halls.id')
            ->select('connections.*', 'halls.hall_name')
            ->where('start_time', 'LIKE', $date . '%')
            ->where('on_sale', '=', 1)
            ->orderBy('id_movie')
            ->orderBy('id_hall')
            ->orderBy('start_time')->get();
    }

    public function getDataOfMovie($id_movie) {

        return Movie::findOrFail($id_movie);
    }

    public function getHallName($id_hall) {

        return Hall::findOrFail($id_hall);
    }



}
