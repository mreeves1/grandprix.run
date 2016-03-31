<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

# Models
use App\Distance;
use App\Gender;
use App\Record;

class RecordController extends Controller
{
    private function getDistances()
    {
        $distances_rs = Distance::orderBy('sort_order', 'asc')->get();
        $distances = [0 => 'Choose a distance'];
        foreach ($distances_rs as $d) {
            $distances[$d->id] = $d->name;
        }

        return $distances;
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
            'distance_id' => 'required|exists:distances,id',
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
     * Display a listing of the records.
     * TODO: Add filters?
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = Record::orderBy('created_at', 'asc')->get();

        return view('record.index', [ 'title' => 'View Records', 'records' => $records]);
    }

    /**
     * Show the form for creating a new record.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $action = \URL::route('record.store');

        return view('record.create_edit',
            [
                'title' => 'Add New Record',
                'distances' => $this->getDistances(),
                'genders' => $this->getGenders(),
                'status' => $this->getStatus()
            ]
        );
    }

    /**
     * Store a newly created record in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->getValidator($request);
        if ($validator->fails()) {
            return redirect('/record/create')
                ->withInput()
                ->withErrors($validator);
        }

        $record = new Record;
        $record->first_name = $request->first_name;
        $record->last_name = $request->last_name;
        $record->age = $request->age;
        $record->birth_date = $request->birth_date;
        $record->gender_id = $request->gender_id;
        $record->distance_id = $request->distance_id;
        $record->race_name = $request->race_name;
        $record->race_date = $request->race_date;
        $record->race_location = $request->race_location;
        $record->race_notes = $request->race_notes;
        $record->active = $request->active;
        $record->save();

        \Session::flash('alert-success', 'New record added.');

        return redirect('/records');
    }

    /**
     * Display the specified record.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $record = Record::findOrFail($id);

        return view('record.show', [
            'title' => 'View Record Details',
            'record' => $record,
            'distances' => $this->getDistances(),
            'genders' => $this->getGenders(),
            'status' => $this->getStatus()
        ]);
    }

    /**
     * Show the form for editing the specified record.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $record = Record::findOrFail($id);
        $action = \URL::route('record.update', ['id' => $id]);

        return view('record.create_edit',
            [
                'record' => $record,
                'title' => 'Edit Record',
                'distances' => $this->getDistances(),
                'genders' => $this->getGenders(),
                'status' => $this->getStatus()
            ]
        );
    }

    /**
     * Update the specified record in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $record = Record::findOrFail($id);

        $validator = $this->getValidator($request);
        if ($validator->fails()) {
            return redirect("/record/$id/edit/")
                ->withInput()
                ->withErrors($validator);
        }

        $record->first_name = $request->first_name;
        $record->last_name = $request->last_name;
        $record->age = $request->age;
        $record->birth_date = $request->birth_date;
        $record->gender_id = $request->gender_id;
        $record->distance_id = $request->distance_id;
        $record->race_name = $request->race_name;
        $record->race_date = $request->race_date;
        $record->race_location = $request->race_location;
        $record->race_notes = $request->race_notes;
        $record->active = $request->active;
        $record->update();

        \Session::flash('alert-success', 'Record updated.');

        return redirect('/records');
    }

    /**
     * Remove the specified record from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Record::findOrFail($id)->delete();

        \Session::flash('alert-success', 'Record deleted.');

        return redirect('/records');
    }
}
