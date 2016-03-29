<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

# Models
use App\Club;
use App\State;

class ClubController extends Controller
{
    private function getStates()
    {
        $states_rs = State::orderBy('name', 'asc')->get();
        $states = [0 => 'Choose a state'];
        foreach ($states_rs as $s) {
            $states[$s->abbreviation] = $s->name;
        }

        return $states;
    }

    private function getValidator($request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|max:200',
            'city' => 'required|max:50',
            'state' => 'required|max:2|exists:states,abbreviation',
            'zip_code' => 'max:10',
            'contact_name' => 'max:200',
            'contact_website' => 'sometimes|url|max:255',
            'contact_email' => 'sometimes|email|max:255',
            'contact_phone' => 'max:25',
        ]);

        return $validator;
    }

    /**
     * Display a listing of the clubs.
     * TODO: Add filters?
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clubs = Club::orderBy('created_at', 'asc')->get();

        return view('club.index', [ 'title' => 'View Clubs', 'clubs' => $clubs, 'states' => $this->getStates()]);
    }

    /**
     * Show the form for creating a new club.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $action = \URL::route('club.store');

        return view('club.create_edit', ['title' => 'Add New Club', 'states' => $this->getStates()]);
    }

    /**
     * Store a newly created club in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->getValidator($request);
        if ($validator->fails()) {
            return redirect('/club/create')
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

        \Session::flash('alert-success', 'New club added.');

        return redirect('/clubs');
    }

    /**
     * Display the specified club.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $club = Club::findOrFail($id);

        return view('club.show', ['club' => $club, 'title' => 'View Club Details']);
    }

    /**
     * Show the form for editing the specified club.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $club = Club::findOrFail($id);
        $action = \URL::route('club.update', ['id' => $id]);

        return view('club.create_edit', ['club' => $club, 'title' => 'Edit Club', 'states' => $this->getStates()]);
    }

    /**
     * Update the specified club in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $club = Club::findOrFail($id);

        $validator = $this->getValidator($request);
        if ($validator->fails()) {
            return redirect("/club/$id/edit/")
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

        \Session::flash('alert-success', 'Club updated.');

        return redirect('/clubs');
    }

    /**
     * Remove the specified club from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Club::findOrFail($id)->delete();

        \Session::flash('alert-success', 'Club deleted.');

        return redirect('/clubs');
    }
}
