<?php

namespace App\Http\Controllers;

use App\Models\Campagne;
use App\Models\Participation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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


    public function participer(Request $request)
        {
            // Validation des champs

            $validator = Validator::make($request->all(), [
                'description' => 'required|string|max:255',
                'video' => 'required', // 10MB max
//                'video' => 'required|file|mimes:mp4,avi,mov,wmv,3gp,flv,m3u8 |max:10240', // 10MB max
                'campagne_id' => 'required|integer'

            ]);



            //check if validation fails
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }


            // Enregistrement de la vidéo dans le dossier storage/app/public/videos
            if ($request->hasFile('video')) {
                $videoPath = $request->file('video')->store('videos', 'public');
            }

            // Vous pouvez sauvegarder les informations dans la base de données ici
            // Par exemple, créer une nouvelle participation

            $participation =Participation::where("campagne_id",$request->campagne_id)
                ->where('user_id',$request->user()->id) ->first();

            if ($participation ==null){
                $participation = new Participation();
            }


            $participation->campagne_id = $request->campagne_id;
            $participation->description = $request->description;
            $participation->video = $videoPath; // Chemin de la vidéo enregistrée
            $participation->user_id = $request->user()->id;
            $participation->status="EN COURS D'EXAMEN";// Chemin de la vidéo enregistrée
            $participation->save();

            $campagne= Campagne::find($request->campagne_id);
        //    $campagne->increment('nbr_participant');

            $campagne->nbr_participant  = $campagne->nbr_participant+ 1;
            $campagne->save();

//            Campagne::where('id', $request->campagne_id)->increment('nbr_participant');

            // Réponse de succès
            return response()->json([
                'message' => 'Participation envoyée avec succès',
                'video_url' => Storage::url($videoPath) // Renvoie l'URL de la vidéo enregistrée
            ], 200);
        }

    public function mes_participation(Request $request){

        $participation=Participation::where('user_id',$request->user()->id)->get();

        $ls=[];
        foreach ($participation as $item){

            $p['id'] = $item->id;
            $p['description']=$item->description;
            $p['video']=$item->video;
            $p['rang']=$item->rang;
            $p['campagne_titre']=$item->campagne->titre;
            $p['campagne_image']=$item->campagne->image;
            $p['campagne_id']=$item->campagne_id;
            $p['user_id']=$item->user_id;
            $p['status']=$item->status;
            $p['etat']=$item->campagne->status;
            $p['created_at']=$item->created_at;
            $p['updated_at']=$item->updated_at;

////            $p=$item;
//            $p['campagne_titre']=$item->campagne->titre;
//
            array_push($ls, $p);


//            $item['etat']=$item->campagne->status;
//            $item['campagne_titre']=  $item->campagne->titre;
        }


        return response()->json($ls, 200);

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
