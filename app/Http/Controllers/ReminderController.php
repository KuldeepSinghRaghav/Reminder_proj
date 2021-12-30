<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Reminder;
use Illuminate\Support\Facades\Validator;


class ReminderController extends Controller
{
    

    public function createreminder(Request $req)
    {
        //Validate data
        $data = $req->only('title_id', 'description', 'date','priority_id','status_id');
        $validator = Validator::make($data, [
            'title_id'=>'required',
            'description'=>'required',
            'date'=>'required',
            'priority_id'=>'required',
            'status_id'=>'required'
        ]);
        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        //Request is valid, create new reminder
        $data = new Reminder;
        $data->title_id=$req->title_id;
        $data->description=$req->description;
        $data->date=$req->date;//y/m/d
        $data->priority_id=$req->priority_id;
        $data->status_id=$req->status_id;
        $result=$data->save();

        if($result){
            return response()->json(['success'=>"saved successfully."]);
          }
        else{
            return response()->json(['failed'=>"create failed"]);
          }
    }

    public function getreminder(Request $req)
    {
        //Validate data
        $data = $req->only('token');
        $validator = Validator::make($data, [
            'token'=>'required'
        ]);
        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        //Request is valid, get reminder data
        // $data = Reminder::with('cat','priority','status')->get();
        $data = Reminder::all();

        if($data){
            return $data;
        }
        else{
            return response()->json(['status'=>"no data found"]);
        }
    }

    public function deletereminder($id)
    {   
        $data=Reminder::find($id);
        if($data){
            $data->delete();
            return response()->json(['success'=>"delete successfully."]);
        }
        else{
            return response()->json(['failed'=>"No data found."]);
        }
    }    
   
    public function updatereminder(Request $req)
    {
        $data =Reminder::find($req->id);
        $data->title_id=$req->title_id;
        $data->description=$req->description;
        $data->date=$req->date;
        $data->priority_id=$req->priority_id;
        $data->status_id=$req->status_id;

        $result=$data->update();
        if($result){
            return response()->json(['success'=>"update successfully."]);
        }
        else{
            return response()->json(['failed'=>"update failed."]);
        }
    }

    

    public function searchByDate(Request $req)
    {
        $data = Reminder::where('date','>=',$req->from)->where('date','<=',$req->to)->get();
        $globaldata = $data; 
        if($data){
            return $data;
        }
        else{
            return response()->json(['failed'=>"No data found."]);
        }
    }

    public function selectDataDelete(Request $req)
    {
       
        $data = Reminder::where('date','>=',$req->from)->where('date','<=',$req->to)->where('status_id','2')->delete();
        if($data){
            return response()->json(['success'=>"Deleted successfully."]);
        }
        else{
            return response()->json(['failed'=>"No data found."]);
        }
    }  
    
    public function deletedAllCompleted(Request $req)
    {
        $data = Reminder::where('status_id','2')->delete();
        if($data){
            return response()->json(['success'=>"Deleted successfully."]);
        }
        else{
            return response()->json(['failed'=>"No data found."]);
        }
    }  
}
