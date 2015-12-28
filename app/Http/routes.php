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

# TODO: Refactor to use controllers
use App\Club;
use App\Gender;
use App\Record;
use App\Runner;
use App\State;
use Illuminate\Http\Request;
use GrahamCampbell\Markdown\Facades\Markdown;

Route::get('/', function () {
    $readme = file_get_contents('../README.md');
    $body = Markdown::convertToHtml($readme);
    return view('index', [ 'title' => 'Grandprix.run', 'body' => $body ]); // default
});

/**
 * Display All Records
 */
Route::get('/records', function () {
    $records = Record::orderBy('created_at', 'asc')->get();
    return view('records', [ 'title' => 'Records', 'records' => $records ]);
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
    Record::findOrFail($id)->delete();

    return redirect('/records');
});

/**
 * Display All Clubs
 */
Route::get('/clubs', function () {
    // States
    $states_rs = State::orderBy('name', 'asc')->get();
    $states = [];
    $states[0] = 'Choose a state';
    foreach ($states_rs as $s) {
        $states[$s->abbreviation] = $s->name; // TODO: Make this a real relation?
    }

    $clubs = Club::orderBy('created_at', 'asc')->get();
    return view('clubs', [ 'title' => 'Clubs', 'clubs' => $clubs, 'states' => $states ]);
});

/**
 * Add A New Club
 */
Route::post('/club', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'name' => 'required|max:200',
        'city' => 'required|max:50',
        'state' => 'required|max:2|exists:states,abbreviation', // TODO: Make this a real relation
        'zip_code' => 'max:10',
        'contact_name' => 'max:200',
        'contact_website' => 'max:255',
        'contact_email' => 'max:255',
        'contact_phone' => 'max:25',
    ]);

    if ($validator->fails()) {
        return redirect('/clubs')
            ->withInput()
            ->withErrors($validator);
    }

    $club = new Club;
    $club->name = $request->name;
    $club->city = $request->city;
    $club->state = $request->state;
    $club->zip_code = $request->zip_code;
    $club->contact_name = $request->contact_name;
    $club->contact_website = $request->contact_website;
    $club->contact_email = $request->contact_email;
    $club->contact_phone = $request->contact_phone;
    $club->save();

    return redirect('/clubs');
});

/**
 * Edit A Club
 */
Route::get('/club/{id}', function ($id, Request $request) {
    $club = Club::findOrFail($id);
    $request->name = $club->name;
    $request->city = $club->city;
    $request->state = $club->state;
    $request->zip_code = $club->zip_code;
    $request->contact_name = $club->contact_name;
    $request->contact_website = $club->contact_website;
    $request->contact_email = $club->contact_email;
    $request->contact_phone = $club->contact_phone;

    return redirect('/clubs');
});

/**
 * Update A Club
 */
Route::put('/club/{id}', function ($id, Request $request) {
    $club = Club::findOrFail($id);

    $validator = Validator::make($request->all(), [
        'name' => 'required|max:200',
        'city' => 'required|max:50',
        'state' => 'required|max:2|exists:states,abbreviation', // TODO: Make this a real relation
        'zip_code' => 'max:10',
        'contact_name' => 'max:200',
        'contact_website' => 'max:255',
        'contact_email' => 'max:255',
        'contact_phone' => 'max:25',
    ]);

    if ($validator->fails()) {
        return redirect('/clubs')
            ->withInput()
            ->withErrors($validator);
    }

    $club->name = $request->name;
    $club->city = $request->city;
    $club->state = $request->state;
    $club->zip_code = $request->zip_code;
    $club->contact_name = $request->contact_name;
    $club->contact_website = $request->contact_website;
    $club->contact_email = $request->contact_email;
    $club->contact_phone = $request->contact_phone;
    $club->update();

    return redirect('/clubs');
});

/**
 * Delete An Existing Club
 */
Route::delete('/club/{id}', function ($id) {
    Club::findOrFail($id)->delete();

    // Session::flash('alert-success', 'Club deleted.'); // TODO: Suss out success messages...
    return redirect('/clubs');
});

/**
 * Display All Runners
 */
Route::get('/runners', function () {
    // Genders
    $genders_rs = Gender::orderBy('name', 'asc')->get();
    $genders = [];
    $genders[0] = 'Choose a gender';
    foreach ($genders_rs as $g) {
        $genders[$g->id] = $g->name;
    }

    // Clubs
    $clubs_rs = Club::orderBy('name', 'asc')->get();
    $clubs = [];
    $clubs[0] = 'Choose a club';
    foreach ($clubs_rs as $c) {
        $clubs[$c->id] = $c->name;
    }

    $runners = Runner::orderBy('created_at', 'asc')->get();
    return view('runners',
                [
                    'title' => 'Runners',
                    'clubs' => $clubs,
                    'genders' => $genders,
                    'runners' => $runners,
                ]);
});

/**
 * Add A New Runner
 */
Route::post('/runner', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'first_name' => 'required|max:100',
        'last_name' => 'required|max:100',
        'email' => 'email|max:255',
        'birth_date' => 'date', // need to look into this further
        'gender_id' => 'required|exists:genders,id',
        'club_id' => 'required|exists:clubs,id',
        'active' => 'required|boolean',
    ]);

    if ($validator->fails()) {
        return redirect('/runners')
            ->withInput()
            ->withErrors($validator);
    }

    $runner = new Runner;
    $runner->first_name = $request->first_name;
    $runner->last_name = $request->last_name;
    $runner->email = $request->email;
    $runner->birth_date = $request->birth_date;
    $runner->gender_id = $request->gender_id;
    $runner->club_id = $request->club_id;
    $runner->active = $request->active;
    $runner->save();

    return redirect('/runners');
});

/**
 * Delete An Existing Runner
 */
Route::delete('/runner/{id}', function ($id) {
    Runner::findOrFail($id)->delete();

    return redirect('/runners');
});
