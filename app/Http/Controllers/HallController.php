<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Connection;
use App\Movie;
use App\Hall;
use App\Place;

class HallController extends Controller
{
    public function getJson($id)
    {
        $reservation = Connection::find($id);
        $hall = Hall::find($reservation->id_hall);
        $palces = Place::where('id_connections', '=', $id)->get();

//        return $palces;
//        return $reservation;
//        return $hall;

        return [
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
        $place = Place::findOrFail($id);

        if ($place->status == 'taken' || $place->type == 'disabled') {
            die();
        }

        if ($place->status == 'selected') {
            $place->status = '';
        } else {
            $place->status = 'selected';
        }

        $place->save();

    }
}
