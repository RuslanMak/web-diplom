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
      $movieName = $movie->name;
//      dd($reservation->id);
      dd($reservation);
//      dd($movieName);

      return view('client.hall');
  }

  public function payment() {
      return view('client.payment');
  }

  public function ticket() {
      return view('client.ticket');
  }

}
