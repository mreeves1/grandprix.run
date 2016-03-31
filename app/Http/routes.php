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
use App\Role;
use App\State;
use App\User;

use Illuminate\Http\Request;
use GrahamCampbell\Markdown\Facades\Markdown;

/**
 * Homepage
 */
Route::get('/', function () {
    $readme = file_get_contents('../README.md');
    $body = Markdown::convertToHtml($readme);
    return view('index', [ 'title' => 'Grandprix.run', 'body' => $body ]); // default
});

/**
 * Clubs
 */
Route::get('clubs', 'ClubController@index');
Route::resource('club', 'ClubController');

/**
 * Records
 */
Route::get('records', 'RecordController@index');
Route::resource('record', 'RecordController');

/**
 * Display All Users
 */
Route::get('/users', function () {
    // Roles
    $roles_rs = Role::orderBy('name', 'asc')->get();
    $roles = [];
    $roles[0] = 'Choose a roles';
    foreach ($roles_rs as $r) {
      $roles[$r->id] = $r->name;
    }

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

    $users = User::orderBy('created_at', 'asc')->get();
    return view('users',
                [
                    'title' => 'Users',
                    'clubs' => $clubs,
                    'genders' => $genders,
                    'roles' => $roles,
                    'users' => $users,
                ]);
});


/**
 * Add A New User
 */
Route::post('/user', function (Request $request) {
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
        return redirect('/users')
            ->withInput()
            ->withErrors($validator);
    }

    $user = new User;
    $user->first_name = $request->first_name;
    $user->last_name = $request->last_name;
    $user->email = $request->email;
    $user->birth_date = $request->birth_date;
    $user->gender_id = $request->gender_id;
    $user->club_id = $request->club_id;
    $user->active = $request->active;
    $user->save();

    return redirect('/users');
});

/**
 * Delete An Existing User
 */
Route::delete('/user/{id}', function ($id) {
    User::findOrFail($id)->delete();

    return redirect('/users');
});
