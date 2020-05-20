<?php

namespace App\Http\Controllers;

use App\Purchase;
use App\Http\Requests\PurchasesRequest;


class PurchaseController extends Controller
{

    public function index()

    {
        $purchases = Purchase::with('offering')->get();
        return response()->json([
            "purchases" => $purchases
        ], 200);
    }

    public function show($id)
    {
        $purchase = Purchase::find($id);
        if (!$purchase) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, purchase with id ' . $id . ' cannot be found'
            ], 400);
        }
        return response()->json([
            "purchase" => $purchase
        ], 200);
    }

    public function store(PurchasesRequest $request)
    {
        $purchase = new Purchase();
        $purchase->customerName = $request->customerName;
        $purchase->quantity = $request->quantity;
        $purchase->offeringID = $request->offeringID;
        if ($purchase->save()){
            $purchases =  Purchase::with('offering')->get();
            return response()->json([
                'success' => true,
                'purchases' => $purchases,
            ],200);
        } else
            return response()->json([
                'success' => false,
                'message' => 'Sorry, purchase could not be added'
            ], 400);
    }

    public function update(PurchasesRequest $request,$id)
    {
        $purchase = Purchase::with('offering')->find($id)->update($request->all());
        if ($purchase){
            $purchases = purchase::with('offering')->get();
            return response()->json([
                'success' => true,
                'purchases' => $purchases,
            ],200);
        } else
            return response()->json([
                'success' => false,
                'message' => 'Sorry, purchase could not be updated'
            ], 400);
    }

    public function destroy($id)
    {
        $purchase = Purchase::find($id);
        if (!$purchase) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, purchase with id ' . $id . ' cannot be found'
            ], 400);
        }

        if ($purchase->delete()) {
            $purchases =  Purchase::with('offering')->get();
            return response()->json([
                'success' => true,
                'purchases' => $purchases
            ]);
        } else
            return response()->json([
                'success' => false,
                'message' => 'Purchase could not be deleted'
            ], 400);
    }

}
