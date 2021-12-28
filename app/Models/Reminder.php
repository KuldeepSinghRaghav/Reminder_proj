<?php

namespace App\Models;
use App\Models\Category;
use App\Models\ReminderPriority;
use App\Models\Reminderstatus;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;
    
   public function cat(){
       return $this->belongsTo(Category::class,'title_id','id');
   }
   public function priority(){
       return $this->belongsTo(ReminderPriority::class,'priority_id','id');
   }
   public function status(){
       return $this->belongsTo(Reminderstatus::class,'status_id','id');
   }
}
