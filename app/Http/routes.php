<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\Record;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome'); // default
});

/**
 * Display All Records
 */
Route::get('/records', function () {
    $records = Record::orderBy('created_at', 'asc')->get();
    return view('records', [ 'records' => $records ]);
});

/**
 * Add A New Record
 */
Route::post('/record', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'first_name' => 'required|max:100',
        'last_name' => 'required|max:100',
    ]);

    if ($validator->fails()) {
        return redirect('/records')
            ->withInput()
            ->withErrors($validator);
    }

    $record = new Record;
    $record->first_name = $request->first_name;
    $record->last_name = $request->last_name;
    $record->save();

    return redirect('/records');
});

/**
 * Delete An Existing Record
 */
Route::delete('/record/{id}', function ($id) {

});

