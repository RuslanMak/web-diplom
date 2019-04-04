<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Connection;
use App\Movie;
use App\Hall;
use App\Place;

class HallController extends Controller
{
//    проверку на аудентыфикацию добавил в web.php
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    public function hall($id) {
        $reservation = Connection::find($id);
        $movie = Movie::find($reservation->id_movie);
        $hall = Hall::find($reservation->id_hall);

        $movieName = $movie->name;
        $startTime = $reservation->start_time;
        $connectionid = $reservation->id;

//      dd($reservation);
//      dd($startTime);
//      dd($movieName);
//      dd($hall);
//      $hall = [$hall];
//      dd(json_encode($hall));

        return view('client.hall')
            ->with('movieName', $movieName)
            ->with('startTime', $startTime)
            ->with('hall', $hall)
            ->with('connectionid', $connectionid);
    }

    public function getJson($id)
    {
        $reservation = Connection::find($id);
        $hall = Hall::find($reservation->id_hall);
        $palces = Place::where('id_connections', '=', $id)->get();
        $userId = request()->user()->id;

//        return $palces;
//        return $reservation;
//        return $hall;

        return [
            'auth_user_id' => $userId,
            'hall' => $hall,
            'places' => $palces
        ];

//        return [
//            array(
//                'title' => 'Google',
//                'url' => 'https://google.com'
//            ),
//            array(
//                'title' => 'Yandex',
//                'url' => 'http://ya.ru'
//            )
//        ];
    }

    public function updateStatus($id)
    {
//        dd(request()->user()->id);

        $place = Place::findOrFail($id);

        $placeUserId = $place->id_user;
        $userAuthorizedId = request()->user()->id;

        if ($place->status == 'taken' || $place->type == 'disabled') {
            die();
        }

        if ($place->status == 'selected' && $placeUserId === $userAuthorizedId) {
            $place->status = '';
            $place->id_user = 0;
        } elseif ($placeUserId == 0) {
            $place->status = 'selected';
            $place->id_user = $userAuthorizedId;
        }

        $place->save();

    }
}
