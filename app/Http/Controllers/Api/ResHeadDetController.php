<?php

namespace App\Http\Controllers\Api;

use App\Models\Room;
use App\Models\Guest;
use App\Models\resDetail;
use App\Models\resHeader;
use Illuminate\Http\Request;
use App\Rules\RuleRoomReserve;
use App\Rules\RuleRoomNotFound;
use App\Rules\RuleGuestAlreadyReserve;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ResHeadDetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return resDetail::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'guestID' => ['required', new RuleGuestAlreadyReserve ], 
            'guestFirst' => 'required',
            'guestLast' => 'required',
            'guestAddress' => 'required',
            'guestContact' => 'required|numeric',
            'resDetailRmNum' => ['required', new RuleRoomReserve, 
                                    new RuleRoomNotFound ],
            'resDetailPrice' => 'required',
            'resDetailRmType' => 'required',
            'resDetailCheckInDate' => 'required',
        ]);

        //SAVING
        $guest = new Guest;
        $resDetail = new resDetail;
        $resHeader = new resHeader;

        $guest->guestID = $request->guestID;
        $guest->guestFirst = $request->guestFirst;
        $guest->guestLast = $request->guestLast;
        $guest->guestAddress = $request->guestAddress;
        $guest->guestContact = $request->guestContact;

        $resDetail->resDetailGuestID = $request->guestID;
        $resDetail->resDetailRmNum = $request->resDetailRmNum;
        $resDetail->resDetailPrice = $request->resDetailPrice;
        $resDetail->resDetailRmType =  $request->resDetailRmType;
        $resDetail->resDetailCheckInDate = $request->resDetailCheckInDate;

        $resHeader->resHeaderGuestID =  $request->guestID;
        $resHeader->resHeaderCheckInDate = $request->resDetailCheckInDate;

        DB::update('UPDATE tblroom SET rmStatus = "RS" WHERE rmNo = ?', [$resDetail->resDetailRmNum]);
        
        $guest->save();
        $resDetail->save();
        $resHeader->save();
        
        return response()->json(
            [
                'status_code' => JsonResponse::HTTP_OK,
                'msg' => 'You are now checked-In On this room'
            ],
            JsonResponse::HTTP_OK
        );
        
    }

    public function srchRoom($rmNo){
        
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
            })->get(['rmNo','rmType','rmPrice']);
        }
        
    }

    public function srchGuest($guestID){
        
        $guestID = Guest::where('guestID', $guestID )->doesntExist();
            
        if($guestID) {
            return response()->json(
                [
                    'status_code' => JsonResponse::HTTP_NOT_FOUND,
                    'errors'=>'Guest ID not found'
                ]
            );
        } else {
            return Guest::query()
            ->when(request()->url('guestID'), function($query){
                return $query->where('guestID',  request('guestID') );   
            })->get(['guestID','guestFirst','guestLast']);
        }
        
    }

    public function guestChkOut($resDetailGuestID)
	{
		$ifChkOut = DB::update('UPDATE tblresdetailfile SET  resDetailCheckOutDate = now() WHERE resDetailGuestID = ?', [$resDetailGuestID]) && DB::update('UPDATE tblresheaderfile SET  resHeaderCheckOutDate = now() WHERE resHeaderGuestID = ?', [$resDetailGuestID]) ;

		if(!$ifChkOut){
			return response()->json(
					[
						'status_code' => JsonResponse::HTTP_NOT_FOUND,
						'msg'=>'Guest has been CheckOut'
					]
			);
		} 
	}

    public function AllGuest(){
        return Guest::when(request('search'), function($query){
            $query->where('guestID', request('search'));
        })->paginate(4);
    }

    public function showSingleGuests($resDetailGuestID)
    {
        $resDetailGuestID = resDetail::where('resDetailGuestID', $resDetailGuestID )->doesntExist();
            
        if($resDetailGuestID) {
            return response()->json(
                [
                    'status_code' => JsonResponse::HTTP_NOT_FOUND,
                    'msg'=>'ResDetail No. not found'
                ]
            );
        } else {
            return resDetail::query()
            ->when(request()->url('resDetailGuestID'), function($query){
                return $query->where('resDetailGuestID',  request('resDetailGuestID') );   
            })->get();
        }
    }

    
}
