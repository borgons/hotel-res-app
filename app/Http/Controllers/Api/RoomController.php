<?php

namespace App\Http\Controllers\Api;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Room::all();
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
            'rmNo' => 'required',
            'rmType' => 'required',
            'rmPrice' => 'required',
            'rmDesc' => 'required'
        ]);

        //SAVING
        $room = new Room;

        $room->rmNo = $request->input('rmNo');
        $room->rmType = $request->input('rmType');
        $room->rmPrice = $request->input('rmPrice');
        $room->rmDesc = $request->input('rmDesc');

        #SAVE

        $room->save();

        return response()->json(
            [
                'status_code' => JsonResponse::HTTP_OK,
                'message' => 'Room has been added'
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
        $id = Room::find($id);

        if(!$id){
            return response()->json(
                [
                    'status_code' => JsonResponse::HTTP_NOT_FOUND,
                    'msg'=>'Room ID not found'
                ]
            );
        } else {
            return $id;
        }

    }

    //SEARCH ROOMS
    public function search($rmNo)
    {
        $rmNo = Room::where('rmNo', $rmNo )->doesntExist();
            
        if($rmNo) {
            return response()->json(
                [
                    'status_code' => JsonResponse::HTTP_NOT_FOUND,
                    'msg'=>'Room No. not found'
                ]
            );
        } else {
            return Room::query()
            ->when(request()->url('rmNo'), function($query){
                return $query->where('rmNo',  request('rmNo') );   
            })->get();
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
        $roomID = Room::find($id);

        if(!$roomID){
            return response()->json(
                [
                    'status_code' => JsonResponse::HTTP_NOT_FOUND,
                    'msg'=>'Room ID not found'
                ]
            );
        } else {
            $roomID->update($request->all());
            return $roomID;
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
        $roomID = Room::destroy($id);

        if(!$roomID){
            return response()->json(
                [
                    'status_code' => JsonResponse::HTTP_NOT_FOUND,
                    'msg'=>'Room ID not found'
                ]
            );
        } else {
            return response()->json(
                [
                    'status_code' => JsonResponse::HTTP_OK,
                    'msg'=>'Room crendentials has been deleted'
                ]
            );
        }  
    }

    public function rmReserve($rmNo) {

        $rmNo = Room::where('rmNo', $rmNo )->doesntExist() ||
                DB::select('SELECT * FROM  tblroom WHERE rmNo = :rmNo AND rmStatus = :rmStatus', 
                [ 'rmNo' => $rmNo,'rmStatus' => 'RS']);

        if($rmNo) {
            return response()->json(
                [
                    'status_code' => [JsonResponse::HTTP_NOT_FOUND,JsonResponse::HTTP_NOT_ACCEPTABLE],
                    'msg'=>['Room No. not found', 'Room has been reserved']
                ]
            );
        }  else {
            return Room::query()
            ->when(request()->url('rmNo'), function($query){
                return $query->where('rmNo',  request('rmNo'))->where('rmStatus', 'NRS') ;   
            })->get();
            
            
        } 
    }
}
