<?php

namespace App\Http\Controllers\Api;

use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class GuestController extends Controller
{
   /**
       * Display a listing of the resource.
      *
      * @return \Illuminate\Http\Response
      */
      public function index()
      {
         return Guest::all();
      }

      /**
       * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
      public function store(Request $request)
      {
         $this->validate($request,[
            'guestID' => 'required', 
            'guestFirst' => 'required',
            'guestLast' => 'required',
            'guestAddress' => 'required',
            'guestContact' => 'required'
         ]);

            //SAVING
            $guest = new Guest;

            $guest->guestID = $request->input('guestID');
            $guest->guestFirst = $request->input('guestFirst');
            $guest->guestLast = $request->input('guestLast');
            $guest->guestAddress = $request->input('guestAddress');
            $guest->guestContact = $request->input('guestContact');
         
            # SAVE
            $guest->save();

            return response()->json(
                  [
                     'status_code' => JsonResponse::HTTP_OK,
                     'msg' => 'Guest has been added'
                  ],
                  JsonResponse::HTTP_NOT_ACCEPTABLE
            );
         
      }

      /**
       * Display the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
      public function show($id)
      {
         $id = Guest::find($id);
         
         if(!$id){
            return response()->json(
                  [
                     'status_code' => JsonResponse::HTTP_NOT_FOUND,
                     'msg' => 'Guest ID not found'
                  ]
            );
         } else {
            return $id;
         }
            
      }

      /**
       * Update the specified resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
      public function update(Request $request, $id)
      {
         $guestID = Guest::find($id);

         if(!$guestID){
            return response()->json(
                  [
                     'status_code' => JsonResponse::HTTP_NOT_FOUND,
                     'msg'=>'Guest ID not found'
                  ]
            );
         } else {
            $guestID->update($request->all());
            return $guestID;
         }
      }

      /**
       * Remove the specified resource from storage.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
      public function destroy($id)
      {
         $guestID = Guest::destroy($id);

         if(!$guestID){
            return response()->json(
                  [
                     'status_code' => JsonResponse::HTTP_NOT_FOUND,
                     'msg'=>'Guest ID not found'
                  ]
            );
         } else {
            return response()->json(
                  [
                     'status_code' => JsonResponse::HTTP_OK,
                     'msg'=>'Guest has been deleted'
                  ]
            );
         }
      }
}
