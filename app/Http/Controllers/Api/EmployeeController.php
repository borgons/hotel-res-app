<?php

namespace App\Http\Controllers\Api;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Rules\RuleEmployeeIDAlreadyExist;

class EmployeeController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return Employee::all();
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
			'empID' => ['required', new RuleEmployeeIDAlreadyExist],
			'empFirst' => 'required',
			'empLast' => 'required',
			'empPosition' => 'required'
		]);

		//SAVING
		$emp = new Employee;

		$emp->empID = $request->input('empID');
		$emp->empFirst = $request->input('empFirst');
		$emp->empLast = $request->input('empLast');
		$emp->empPosition = $request->input('empPosition');

		#SAVE

		$emp->save();

		return response()->json(
			[
					'status_code' => JsonResponse::HTTP_OK,
					'msg' => 'Employee has been added'
			],
			JsonResponse::HTTP_OK
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
		$id = Employee::find($id);

		if(!$id){
			return response()->json(
					[
						'status_code' => JsonResponse::HTTP_NOT_FOUND,
						'msg' => 'Employee ID not found'
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
		$empID = Employee::find($id);

		if(!$empID){
			return response()->json(
					[
						'status_code' => JsonResponse::HTTP_NOT_FOUND,
						'msg'=>'Employee ID not found'
					]
			);
		}

		$empID->update($request->all());
		return $empID;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$empID = Employee::destroy($id);

		if(!$empID){
			return response()->json(
					[
						'status_code' => JsonResponse::HTTP_NOT_FOUND,
						'msg'=>'Employee ID not found'
					]
			);
		} else {
			return response()->json(
					[
						'status_code' => JsonResponse::HTTP_OK,
						'msg'=>'Employee has been deleted'
					]
			);

		}
	}
}
