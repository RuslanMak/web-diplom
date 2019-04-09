<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Connection;
use App\Movie;
use App\Hall;
use App\Place;


class AdminsController extends Controller
{
  public function index() {
//        Получение значений столбца 'hall_name'
//      $halls = DB::table('halls')->pluck('hall_name');
      $halls = DB::table('halls')->select('hall_name', 'id')->get();
//      $halls = DB::table('halls')->select('hall_name', 'id')->get()->groupBy('id');
//      dd($halls);

//      $halls = Hall::all();

      return view('admin.index')
          ->with('halls', $halls);
  }

    public function create() {
        return view('admin.create');
    }

    public function save()
    {
//         return request()->all();
//         return request('hall_name');

        $hall = new Hall();
        $hall->hall_name = request('hall_name');
        $hall->rows = 0;
        $hall->places_in_row = 0;
        $hall->save();
        return redirect('/admin');
    }

    public function delete($id)
    {
//        НАДО ДОБАВИТЬ УДАЛЕНИЕ ДАННЫХ ИЗ ДРУГИХ ТАБЛИЦ !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//        dd($id);
//        return request()->all();
        Hall::findOrFail($id)->delete();
        return redirect('/admin');
    }

    public function getApi($id_hall)
    {
        if ( !isset(request()->user()->id) ) {
            return redirect('/');
        }

        $places = Place::where('id_hall', '=', $id_hall)->get();
        $hall = Hall::find($id_hall);

        if ( !isset($places[0]) ) {
//            dd('LOL nothing here');
            return [
                'hall' => $hall,
                'places' => $places
            ];
        } else {
//            dd($places);
//            return $places;
            return [
                'hall' => $hall,
                'places' => $places
            ];
        }
    }

    public function postApiRow($id_hall, $num)
    {
//        $input = request()->all();
//        dd($num);
//        dd($input);

        if ( !isset($id_hall) &&  !isset($num)) {
            return redirect('/');
        }

        $hall = Hall::findOrFail($id_hall);

//        $placeUserId = $place->id_user;
//        $userAuthorizedId = request()->user()->id;

//        if ($place->status == 'taken' || $place->type == 'disabled') {
//            die();
//        }
//
//        if ($place->status == 'selected' && $placeUserId === $userAuthorizedId) {
//            $place->status = '';
//            $place->id_user = 0;
//        } elseif ($placeUserId == 0) {
//            $place->status = 'selected';
//            $place->id_user = $userAuthorizedId;
//        }
//        $hall->rows;
//        dd($hall->rows);
        $hall->admin_doing_rows = $num;

        $hall->save();

//        return redirect('/');
    }

    public function updatePlaceInRow($id_hall, $num)
    {
        if ( !isset($id_hall) &&  !isset($num)) {
            return redirect('/');
        }

        $hall = Hall::findOrFail($id_hall);
        $hall->admin_doing_places = $num;

        $hall->save();

//        return redirect('/');
    }
}
