<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Connection;
use App\Movie;
use App\Hall;
use App\Place;
use App\Price;
use phpDocumentor\Reflection\Types\Object_;


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
//        if ( !isset(request()->user()->id) ) {
//            return redirect('/');
//        }

        $places = Place::where('id_hall', '=', $id_hall)->get();
        $hall = Hall::find($id_hall);

        $id_praces = explode(';', $hall->id_prices);
        $prices = Price::find($id_praces);
        $prices_arr = [];

//        делаю осоциативный массив
        foreach ($prices as $price) {
            $prices_arr += array($price->place_type => $price);
        }

        return [
            'hall' => $hall,
            'prices' => $prices_arr,
            'places' => $places
        ];
    }

    public function updateNumRow($id_hall, $num)
    {
        if ( !isset($id_hall) &&  !isset($num)) {
            return redirect('/');
        }

        $hall = Hall::findOrFail($id_hall);

        $hall->admin_doing_rows = $num;

        $hall->save();

//        return redirect('/');
    }

    public function updateNumPlaceInRow($id_hall, $num)
    {
        if ( !isset($id_hall) &&  !isset($num)) {
            return redirect('/');
        }

        $hall = Hall::findOrFail($id_hall);
        $hall->admin_doing_places = $num;

        $hall->save();

//        return redirect('/');
    }

    public function updateTypePlace($row, $num, $type, $id_hall)
    {
// $place = DB::select("SELECT * FROM places WHERE id_hall = $id_hall AND num_row = $row AND num_place_in_row = $num");

//        $place = DB::table('places')
//            ->where('id_hall', '=', $id_hall)
//            ->where('num_row', '=', $row)
//            ->where('num_place_in_row', '=', $num)
//            ->get();

        $place = Place::where('id_hall', '=', $id_hall)
            ->where('num_row', '=', $row)
            ->where('num_place_in_row', '=', $num)
            ->get();

        if (isset($place[0])) {
//            dd($place[0]->type);
            $place[0]->admin_doing_type = $type;
            $place[0]->save();
        } else {
            $newPlace = new Place();
            $newPlace->id_hall = $id_hall;
            $newPlace->num_row = $row;
            $newPlace->num_place_in_row = $num;
            $newPlace->type = '';
            $newPlace->price = 0;
            $newPlace->id_connections = 0;
            $newPlace->status = '';
            $newPlace->id_user = 0;
            $newPlace->admin_doing_type = $type;
//            dd($newPlace);
            $newPlace->save();
        }

//        return redirect('/');
    }

    public function cancelChange($pass, $id_hall)
    {
        if ($pass != 'herePassword') {
            return redirect('/');
        }

        $hall = Hall::findOrFail($id_hall);
        $hall->admin_doing_rows = 0;
        $hall->admin_doing_places = 0;
//        dd($hall);
        $hall->save();

        Place::where('admin_doing_type', '!=', '')
            ->update(array('admin_doing_type' => ''));

        Place::where('type', '=', '')
            ->delete();

//        return redirect('/');
    }

    public function saveChange($id_hall)
    {
        $hall = Hall::findOrFail($id_hall);

        if ($hall->admin_doing_rows != 0) {
            $hall->rows = $hall->admin_doing_rows;
            $hall->admin_doing_rows = 0;
        }
        if ($hall->admin_doing_places != 0) {
            $hall->places_in_row = $hall->admin_doing_places;
            $hall->admin_doing_places = 0;
        }
        $hall->save();

        $places = Place::where('id_hall', '=', $id_hall)
            ->where('admin_doing_type', '!=', '')
            ->get();

        if (count($places) > 0) {
            foreach ($places as $place) {
                $place->type = $place->admin_doing_type;
                $place->admin_doing_type = '';
                $place->save();
            }
        }

//        return redirect('/');
    }

    public function savePrices()
    {
//         return request()->all();
//         return request('id_hall');

//        основляем цены
        Price::where('id', '=', request('id_standart_place'))
            ->update(['price' => request('standart_place')]);

        Price::where('id', '=', request('id_vip_place'))
            ->update(['price' => request('vip_place')]);

         $hall = Hall::findOrFail(request('id_hall'));
//         проверка на отсутствие id-цен, создание и сохранение цен
         if ( !($hall->id_prices > 0) ) {
             $priceSt = new Price();
             $priceSt->place_type = 'standart';
             $priceSt->price = request('standart_place');
             $priceSt->save();
//             return $priceSt->id;

             $priceVip = new Price();
             $priceVip->place_type = 'vip';
             $priceVip->price = request('vip_place');
             $priceVip->save();

//             записуем id-цен в зале
             $hall->id_prices = $priceSt->id . ';' . $priceVip->id;
             $hall->save();
         }

        return redirect('/admin');
    }

    public function allMoviesApi()
    {
        $movies = DB::table('movies')->select('id', 'name', 'image', 'runtime')->get();
        $connections = Connection::all();

        return [
            'movies' => $movies,
            'connections' => $connections
        ];
    }

    public function saveNewMovie(Request $request)
    {
//        return $request->all();
//        return $request->file('image');
        $path = $request->file('image')->store('uploads', 'public');
//        $path = 'uploads/poster1.jpg';
//        return view('admin.create_movie', ['path' => $path]);

//        return $request->name;
        $movie = new Movie();
        $movie->name = $request->name;
        $movie->image = 'storage/' . $path;
        $movie->description = $request->description;
        $movie->runtime = $request->runtime;
        $movie->country = $request->country;
        $movie->save();

//        return redirect('/admin');
    }

    public function saveMovieTime(Request $request)
    {
        $connections = new Connection();
        $connections->id_hall = $request->id_hall;
        $connections->id_movie = $request->id;
        $connections->start_time = $request->start_time;
        $connections->save();
    }

    public function deleteMovieFromHall(Request $request)
    {
//        return $request;
        Connection::findOrFail($request->id_connection)->delete();
    }
}
