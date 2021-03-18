<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PatientResource;
use App\Patients;

class PatientsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Patients::paginate(10);
        return response()->json($data);
        //return new PatientResource($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $data = $request->validate([
            'idnumber' => 'required|unique:patients,idnumber',
            'passportnumber' => 'required|unique:patients,passportnumber',
            'firstname' => 'required',
            'surname' => 'required',
            'streetaddress' => 'required',
            'city' => 'required',
            'province' => 'required',
        ]);

        $patients = new Patients();
        $patient = $patients->create($request->input());

        return new PatientResource($patient);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Patients $patient, Request $request)
    {
        
        $data = $request->validate([
            'idnumber' => 'required|unique:patients,idnumber,'.$patient->id,
            'passportnumber' => 'required|unique:patients,passportnumber,'.$patient->id,
            'firstname' => 'required',
            'surname' => 'required',
            'streetaddress' => 'required',
            'city' => 'required',
            'province' => 'required',
        ]);
         
        $patient->update($data);

        return new PatientResource($patient);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
