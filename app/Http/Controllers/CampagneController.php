<?php

namespace App\Http\Controllers;

use App\Models\Campagne;
use Illuminate\Http\Request;

class CampagneController extends Controller
{


    public function campagnes_all(){

      $list_campagne=  Campagne::take(20)->orderBy('created_at', 'DESC')->get();;

        $data =  [
            'total_size' => $list_campagne->count(),
            'type_id' => 2,
            'offset' => 0,
            'campagnes' => $list_campagne
        ];

        return response()->json($data, 200);

    }

 public function campagnes_encours(){

      $list_campagne=  Campagne::where('status',"EN COURS")->orderBy('created_at', 'DESC')->get();

        $data =  [
            'total_size' => $list_campagne->count(),
            'type_id' => 2,
            'offset' => 0,
            'campagnes' => $list_campagne
        ];

        return response()->json($data, 200);

    }

    public function getCampagneById($id)
    {
        $campagne = Campagne::find($id);

        if ($campagne) {
            return response()->json([
                'campagne' => $campagne
            ], 200);
        } else {
            return response()->json(['message' => 'Campagne not found'], 404);
        }
    }








    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
