<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hall;
use DB;

class AdminsController extends Controller
{
  public function index() {
//        Получение значений столбца 'hall_name'
//      $halls = DB::table('halls')->pluck('hall_name');
      $halls = DB::table('halls')->select('hall_name', 'id')->get();
//      $halls = DB::table('halls')->select('hall_name', 'id')->get()->groupBy('id');
//      dd($halls);

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
}
