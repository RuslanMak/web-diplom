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
        $hall->places_in_row = 0;
        $hall->admin_doing_rows = 0;
        $hall->admin_doing_places = 0;
        $hall->id_prices = '';
        $hall->save();
//        return redirect('/admin');
    }

    public function deleteHall($id)
    {
        Hall::findOrFail($id)->delete();
        Place::where('id_hall', '=', $id)
            ->delete();

        Connection::where('id_hall', '=', $id)
            ->delete();
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

//         заносим цены в таблицу мест places
        Place::where('id_hall', '=', request('id_hall'))
            ->where('type', '=', 'standart')
            ->update(['price' => request('standart_place')]);

        Place::where('id_hall', '=', request('id_hall'))
            ->where('type', '=', 'vip')
            ->update(['price' => request('vip_place')]);

//        return redirect('/admin');
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
//        dd($request);
        $connections = new Connection();
        $connections->id_hall = $request->id_hall;
        $connections->id_movie = $request->id;
//        $connections->id_movie = $request->id_movie;
        $connections->start_time = $request->start_time;
        $connections->on_sale = 0;
        $connections->save();
//        dd($connections->id);

        $prices_arr = Place::where('id_hall', '=', $connections->id_hall)->get();

        foreach ($prices_arr as $price) {
            $new = $price->replicate();
            $new->id_connections= $connections->id;
            $new->save();
        }
    }

    public function deleteMovieFromHall(Request $request)
    {
//        return $request;
        Connection::findOrFail($request->id_connection)->delete();
    }

    public function openSale()
    {
        Connection::where('on_sale', '=', 0)
            ->update(array('on_sale' => 1));
        return redirect('/');
    }

    public function allHallsApi()
    {
        return Hall::all();
    }


    public function saveTypePlace(Request $request, $rows, $nums, $id_hall)
    {
        $hall = Hall::findOrFail($id_hall);
        $hall->	rows = $rows;
        $hall->	places_in_row = $nums;
        $hall->save();

//        $connection = DB::table('connections')->select('id', 'id_hall')->get();
        $connections = Connection::where('id_hall', '=', $id_hall)->get();

        foreach ($request->input() as $key=>$placeArr) {
//            return $placeArr['type'];
            $place = Place::where('id_hall', '=', $id_hall)
                ->where('num_row', '=', $placeArr['row'])
                ->where('num_place_in_row', '=', $placeArr['num'])
                ->get();

            if (isset($place[0])) {
                $place[0]->	type = $placeArr['type'];
                $place[0]->save();
            } else {
                foreach ($connections as $connection) {
                    $newPlace = new Place();
                    $newPlace->id_hall = $id_hall;
                    $newPlace->num_row = $placeArr['row'];
                    $newPlace->num_place_in_row = $placeArr['num'];
                    $newPlace->type = $placeArr['type'];
                    $newPlace->price = 0;
                    $newPlace->id_connections = $connection->id;
                    $newPlace->status = '';
                    $newPlace->id_user = 0;
                    $newPlace->admin_doing_type = '';
//            dd($newPlace);
                    $newPlace->save();
                }
            }
        }

    }
}
