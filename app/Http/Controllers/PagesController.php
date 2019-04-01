<?php

namespace App\Http\Controllers;

use App\Connection;
use Illuminate\Http\Request;
use App\Movie;
use App\Hall;

class PagesController extends Controller
{
  public function home() {
      return view('welcome');
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

  public function hall($id) {
      $reservation = Connection::find($id);
      $movie = Movie::find($reservation->id_movie);
      $hall = Hall::find($reservation->id_hall);

      $movieName = $movie->name;
      $startTime = $reservation->start_time;

//      dd($reservation);
//      dd($startTime);
//      dd($movieName);
//      dd($hall);
//      $hall = [$hall];
//      dd(json_encode($hall));

      return view('client.hall')
          ->with('movieName', $movieName)
          ->with('startTime', $startTime)
          ->with('hall', $hall);
  }

  public function payment() {
      return view('client.payment');
  }

  public function ticket() {
      return view('client.ticket');
  }

    public function getJson($id)
    {
        $reservation = Connection::find($id);
        $hall = Hall::find($reservation->id_hall);
        return $hall;

        return [
            array(
                'title' => 'Google',
                'url' => 'https://google.com'
            ),
            array(
                'title' => 'Yandex',
                'url' => 'http://ya.ru'
            )
        ];
    }

}
