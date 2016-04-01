<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

# Models
use App\Club;
use App\Gender;
use App\Role;
use App\User;

class UserController extends Controller
{
    private function getClubs()
    {
        $clubs_rs = Club::orderBy('name', 'asc')->get();
        $clubs = [0 => 'Choose a club'];
        foreach ($clubs_rs as $c) {
            $clubs[$c->id] = $c->name;
        }

        return $clubs;
    }

    private function getGenders()
    {
        $genders_rs = Gender::orderBy('name', 'asc')->get();
        $genders = [0 => 'Choose a gender'];
        foreach ($genders_rs as $g) {
            $genders[$g->id] = $g->name;
        }

        return $genders;
    }

    private function getRoles()
    {
        $roles_rs = Role::orderBy('id', 'asc')->get();
        $roles = [0 => 'Choose a role'];
        foreach ($roles_rs as $r) {
            $roles[$r->id] = $r->name;
        }

        return $roles;
    }

    private function getStatus()
    {
         return [1 => 'Active', 0 => 'Inactive'];
    }

    private function getValidator($request)
    {
        $validator = \Validator::make($request->all(), [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'gender_id' => 'required|exists:genders,id',
            'distance_id' => 'required|exists:roles,id',
            'age' => 'required_without:birth_date|integer|max:150',
            'birth_date' => 'required_without:age|date',
            'race_name' => 'required|string|max:255',
            'race_date' => 'required|date',
            'race_location' => 'sometimes|string|max:255',
            'race_notes' => 'sometimes|string|max:255',
            'active' => 'required|boolean'
        ]);

        return $validator;
    }

    /**
     * Display a listing of the users.
     * TODO: Add filters?
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'asc')->get();

        return view('user.index', [ 'title' => 'View Users', 'users' => $users, 'clubs' => $this->getClubs(), 'roles' => $this->getRoles() ]);
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $action = \URL::route('user.store');

        return view('user.create_edit',
            [
                'title' => 'Add New User',
                'clubs' => $this->getClubs(),
                'roles' => $this->getRoles(),
                'genders' => $this->getGenders(),
                'status' => $this->getStatus()
            ]
        );
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->getValidator($request);
        if ($validator->fails()) {
            return redirect('/user/create')
                ->withInput()
                ->withErrors($validator);
        }

        $user = new User;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->age = $request->age;
        $user->birth_date = $request->birth_date;
        $user->gender_id = $request->gender_id;
        $user->distance_id = $request->distance_id;
        $user->race_name = $request->race_name;
        $user->race_date = $request->race_date;
        $user->race_location = $request->race_location;
        $user->race_notes = $request->race_notes;
        $user->active = $request->active;
        $user->save();

        \Session::flash('alert-success', 'New user added.');

        return redirect('/users');
    }

    /**
     * Display the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('user.show', ['user' => $user, 'title' => 'View User Details']);
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $action = \URL::route('user.update', ['id' => $id]);

        return view('user.create_edit',
            [
                'user' => $user,
                'title' => 'Edit User',
                'clubs' => $this->getClubs(),
                'roles' => $this->getRoles(),
                'genders' => $this->getGenders(),
                'status' => $this->getStatus()
            ]
        );
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = $this->getValidator($request);
        if ($validator->fails()) {
            return redirect("/user/$id/edit/")
                ->withInput()
                ->withErrors($validator);
        }

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->age = $request->age;
        $user->birth_date = $request->birth_date;
        $user->gender_id = $request->gender_id;
        $user->distance_id = $request->distance_id;
        $user->race_name = $request->race_name;
        $user->race_date = $request->race_date;
        $user->race_location = $request->race_location;
        $user->race_notes = $request->race_notes;
        $user->active = $request->active;
        $user->update();

        \Session::flash('alert-success', 'User updated.');

        return redirect('/users');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        \Session::flash('alert-success', 'User deleted.');

        return redirect('/users');
    }
}
