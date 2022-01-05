<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Reminder;
use App\Models\Category;
use App\Models\ReminderPriority;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;



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
        $data->status_id="1";
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
        // $data = Reminder::all();
        $data=DB::table('reminders')
             ->join('categories','categories.id','=','reminders.title_id')
             ->join('reminderpriorities','reminderpriorities.id','=','reminders.priority_id')
             ->join('reminderstatus','reminderstatus.id','=','reminders.status_id')
             ->select('reminders.id','categories.title','reminders.description','reminders.date','reminderpriorities.priority','reminderstatus.status')
             ->get();


        // foreach($data as $item)
        // {
        //     return $item->cat->title;
        // }
        if(count($data)==0){
            return response()->json(['status'=>"no data found"]);
        }
        return $data;
    }

    public function deletereminder($id)
    {   
        $data=Reminder::find($id);
        if($data){
            $data->delete();
            return response()->json(['success'=>"delete successfully."]);
        }
        else{
            return response()->json(['status'=>"No data found."]);
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
        // $globaldata = $data; 
        if($data){
            return $data;
        }
        else{
            return response()->json(['failed'=>"No data found."]);
        }
    }

    public function allopendata(Request $req)
    {
        $data = Reminder::where('status_id','2')->get();
        if(count($data) != 0){
            return $data;
        }
            return response()->json(['status'=>"No data found."]);
    }
    public function allclosedata(Request $req)
    {
        $data = Reminder::where('status_id','1')->get();
        if(count($data) != 0){
            return $data;
        }
            return response()->json(['status'=>"No data found."]);
    }

    public function selectDataDelete(Request $req)
    {
       
        $data = Reminder::where('date','>=',$req->from)->where('date','<=',$req->to)->delete();
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

    public function datafordropdown()
    {
        $cat = Category::all('id','title');
        $pri = ReminderPriority::all('id','Priority');
        return $cat.$pri;     
    }
    public function viewReminderUpdatePageStatus($id)
    {   
        $data=DB::table('reminders')->where('reminders.id','=',$id)
        ->join('categories','categories.id','=','reminders.title_id')
        ->join('reminderpriorities','reminderpriorities.id','=','reminders.priority_id')
        ->join('reminderstatus','reminderstatus.id','=','reminders.status_id')
        ->select('reminders.id','categories.title','reminders.description','reminders.date','reminderpriorities.priority','reminderstatus.status')
        ->get();
        if(count($data)!=0)
        {
          $datas=Reminder::find($id);
          if($datas->status_id==1)
          {
            $datas->status_id="2";
            $result=$datas->update();
          }
         return $data;
        }
          else{
            return response()->json(['failed'=>"No data found."]);
               }
    }

    public function viewReminderUpdatePage($id)
    {   
        $data=Reminder::find($id);
        return $data;
    }
}