<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferingsRequest;


class OfferingController extends Controller
{

    protected $user;
    public function __construct()
    {
        $this->user = auth('api')->user();
    }


    public function index()

    {
        $offerings = $this->user->offerings()->get();
        return response()->json([
            "offerings" => $offerings
        ], 200);
    }

    public function show($id)
    {
        $offering = $this->user->offerings()->find($id)->first();
        if (!$offering) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, offering with id ' . $id . ' cannot be found'
            ], 400);
        }
        return response()->json([
            "offering" => $offering
        ], 200);
    }

    public function store(OfferingsRequest $request)
    {
        $credentials = [
            'title'=>$request->title,
            'price' =>$request->price,
            'userID'=>$this->user->id
        ];
        if ($this->user->offerings()->create($credentials)){
            $offerings =  $this->user->offerings()->get();
            return response()->json([
                'success' => true,
                'offerings' => $offerings,
            ],200);
        } else
            return response()->json([
                'success' => false,
                'message' => 'Sorry, offering could not be added'
            ], 400);
    }

    public function update(OfferingsRequest $request, $id)
    {

        $offering = $this->user->offerings()->find($id)->first()->update($request->all());
        if ($offering){
            $offerings = $this->user->offerings()->get();
            return response()->json([
                'success' => true,
                'offerings' => $offerings,
            ],200);
        } else
            return response()->json([
                'success' => false,
                'message' => 'Sorry, offering could not be updated'
            ], 500);
    }

    public function destroy($id)
    {
        $offering = $this->user->offerings()->find($id)->first();
        if (!$offering) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, offering with id ' . $id . ' cannot be found'
            ], 400);
        }

        if ($offering->delete()) {
            $offerings =  $this->user->offerings()->get();
            return response()->json([
                'success' => true,
                'offerings' => $offerings
            ]);
        } else
            return response()->json([
                'success' => false,
                'message' => 'offering could not be deleted'
            ], 400);
    }

}
