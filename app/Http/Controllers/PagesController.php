<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movie;

class PagesController extends Controller
{
  public function home() {
      return view('welcome');
  }

  public function about() {
      $movies = Movie::all();
//      return $movies;
      
      return view('about', compact('movies'));
  }

  public function client() {
      $movies = Movie::all();

      return view('client.index', compact('movies'));
  }

  public function hall() {
      return view('client.hall');
  }

  public function payment() {
      return view('client.payment');
  }

  public function ticket() {
      return view('client.ticket');
  }

}
