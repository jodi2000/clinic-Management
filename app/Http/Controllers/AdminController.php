<?php

namespace App\Http\Controllers;

use App\Exceptions\GeneralJsonExceptions;
use App\Models\Priority;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Evaluation;
use App\Models\Service;
use App\Models\Status;
use App\Models\Technician;
use App\Models\Ticket;
use App\Models\Ticket_technician;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdminController extends Controller
{
    public function create_client(Request $request)
    {
        
        $valid = Validator::make(
            $request->all(),
            [
                'name' => 'required ',
                'phone_number' => 'required|unique:users|min:10|max:10',
                'password' => 'required|min:6',
               
            ]
        );
            if ($valid->fails())
                return response($valid->errors());
                
            $user=User::create([
                'name' => $request->input('name'),
                'phone_number' => $request->input('phone_number'),
                'password' => Hash::make($request->input('password')),
                
                
            ]);

            return response()->json([ $user, "token" => $user->createToken('token')->plainTextToken]);
       
        
    }
    public function update_client(Request $request, $id)
    {
        try {
            $updatedUser = User::findOrFail($id);
            
        } catch (\Exception $e) {
            return response()->json(['message'=>'client not found!'], 404);
        }
        
        $updatedUser->name = empty($request->name) ? $updatedUser->name : $request->name;
        $updatedUser->phone_number = empty($request->phone_number) ? $updatedUser->phone_number : $request->phone_number;
        $updatedUser->save();
        return response()->json([$updatedUser]);
              
    }
    public function delete_client($id)
    {
        try {
            $user = User::findOrFail($id);
            
        } catch (\Exception $e) {
            return response()->json(['message'=>'client not found!'], 404);
        }
        
        if($user!=null){
            $user->delete();
            return response()->json(["successful delete"]);
        }
        
    }
    public function view_client($id,$local)
    {
        $l=App::setLocale($local);
            return response()->json([__('user.user')]);
        try {
            $client=User::where('id', $id)->firstOrFail();
            
            
        } catch (\Exception $e) {
            return response()->json(['message'=>'client not found!'], 404);
        }
        
        
        

    }
    public function create_priority(Request $request)
    {
        $valid = Validator::make(
            $request->all(),
            [
                'title' => 'required|unique:priorities',
                'value' => 'required|unique:priorities',
                
            ]
        );
            if ($valid->fails())
                return response($valid->errors());
                
            $p=Priority::create($request->except('_token'));

            return response()->json([$p]);
    }
    public function update_priority(Request $request, $id)
    {
        try {
            $updatedP = Priority::findOrFail($id);
            
        } catch (\Exception $e) {
            return response()->json(['message'=>'priority not found!'], 404);
        }
        
        $updatedP->title = empty($request->title) ? $updatedP->title : $request->title;
        $updatedP->value = empty($request->value) ? $updatedP->value : $request->value;
        $updatedP->save();
        return response()->json([$updatedP]);
              
    }
    public function delete_priority($id)
    {
        try {
            $p = Priority::findOrFail($id);
            
        } catch (\Exception $e) {
            return response()->json(['message'=>'priority not found!'], 404);
        }
        
        if($p!=null){
            $p->delete();
            return response()->json(["successful delete"]);
        }
        
        
    }
    public function view_priority($id)
    {
        try {
            $priority=Priority::where('id', $id)->firstOrFail();
            
        } catch (\Exception $e) {
            return response()->json(['message'=>'priority not found!'], 404);
        }
        return response()->json([$priority]);

    }
    public function create_Status(Request $request)
    {
        $valid = Validator::make(
            $request->all(),
            [
                'title' => 'required|unique:statuses',
         
            ]
        );
            if ($valid->fails())
                return response($valid->errors());
                
            $p=Status::create($request->except('_token'));

            return response()->json([$p]);
    }
    public function update_Status(Request $request, $id)
    {
        try {
            $updatedS = Status::findOrFail($id);
            
        } catch (\Exception $e) {
            return response()->json(['message'=>'status not found!'], 404);
        }
        $updatedS->title =  empty($request->title) ? $updatedS->title : $request->title;
        $updatedS->save();
        return response()->json([$updatedS]);
              
    }
    public function delete_Status($id)
    {
        try {
            $s = Status::findOrFail($id);
            
        } catch (\Exception $e) {
            return response()->json(['message'=>'status not found!'], 404);
        }
        if($s!=null){
            $s->delete();
            return response()->json(["successful delete"]);
        }
        
        
    }
    public function view_Status($id)
    {
        try {
            $Status=Status::where('id', $id)->firstOrFail();
            
        } catch (\Exception $e) {
            return response()->json(['message'=>'status not found!'], 404);
        }
        return response()->json([$Status]);

    }
    public function create_technicians(Request $request)
    {
        $valid = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:technicians',
                'hour_cost'=>'required'
            
            ]
        );
            if ($valid->fails())
                return response($valid->errors());
                
            $t=Technician::create($request->except('_token'));

            return response()->json([$t]);
    }
    public function update_technicians(Request $request, $id)
    {
        try {
            $updatedT = Technician::findOrFail($id);
            
        } catch (\Exception $e) {
            return response()->json(['message'=>'technicians not found!'], 404);
        }
        $updatedT->name = empty($request->name) ? $updatedT->name : $request->name;
        $updatedT->hour_cost = empty($request->hour_cost) ? $updatedT->hour_cost : $request->hour_cost;
        $updatedT->save();
        
        return response()->json([$updatedT]);
              
    }
    public function delete_technicians($id)
    {
        try {
            $t = Technician::findOrFail($id);
            
        } catch (\Exception $e) {
            return response()->json(['message'=>'technicians not found!'], 404);
        }
        if($t!=null){
            $t->delete();
            return response()->json(["successful delete"]);
        }
        
        
    }
    public function view_technicians($id)
    {
        try {
            $technicians=Technician::where('id', $id)->firstOrFail();
            
        } catch (\Exception $e) {
            return response()->json(['message'=>'technicians not found!'], 404);
        }
        return response()->json([$technicians]);

    }
    public function create_category(Request $request)
    {
        $valid = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:categories',
      
            ]
        );
            if ($valid->fails())
                return response($valid->errors());
                
            $t=Category::create($request->except('_token'));

            return response()->json([$t]);
    }
    
    public function delete_category($id)
    {
        try {
            $c = Category::findOrFail($id);
            
        } catch (\Exception $e) {
            return response()->json(['message'=>'category not found!'], 404);
        }
        
        if($c!=null){
            $c->delete();
            return response()->json(["successful delete"]);
        }
        
        
    }

    public function create_service(Request $request)
    {
        try
        {
            $valid = Validator::make(
                $request->all(),
                [
                    'title' => 'required',
                    'price' => 'required',
                    'category_id'=>'required'
        
                ]
            );
                if ($valid->fails())
                    return response($valid->errors());
                
                $t=Service::create($request->except('_token'));
    
                return response()->json([$t]);
        }
        catch (\Exception $e) {
            return response()->json(['message'=>'something wrong!'], 404);
        }
        
    }
    public function update_service(Request $request,$id)
    {
        try {
            $updatedS = Service::findOrFail($id);
            
        } catch (\Exception $e) {
            return response()->json(['message'=>'service not found!'], 404);
        }
        
        $updatedS->title = empty($request->title) ? $updatedS->title : $request->title;
        $updatedS->price = empty($request->price) ? $updatedS->price : $request->price;
        $updatedS->category_id = empty($request->category_id) ? $updatedS->category_id : $request->category_id;
        $updatedS->save();
        return response()->json([$updatedS]);
              
    }
    public function delete_service($id)
    {
        try {
            $s = Service::findOrFail($id);
            
        } catch (\Exception $e) {
            return response()->json(['message'=>'service not found!'], 404);
        }
        
        if($s!=null){
            $s->delete();
            return response()->json(["successful delete"]);
        }
       
        
    }
    public function view_service($id)
    {
        try {
            $service=Service::where('id', $id)->firstOrFail();
            
        } catch (\Exception $e) {
            return response()->json(['message'=>'service not found!'], 404);
        }
         return response()->json([$service]);

    }
    public function create_ticket(Request $request)
    {
        
        try
        {
            $valid = Validator::make(
                $request->all(),
                [
                    'client_id' => 'required',
                    'priority_id' => 'required',
                    'service_id' => 'required',
                    
                ]
            );
                if ($valid->fails())
                    return response($valid->errors());
                    
                $t=Ticket::create($request->all());
                if(!empty($t))
                {
                    $t->update(['status_id'=>'1']);
                }
                
    
                return response()->json([$t]);
        }
        catch(Exception $e)
        {
            return response()->json([
        
            'error' => $e->getMessage()

        ]);
        return parent::render($request, $e);
        }
    
        
        
    }
    
    public function update_ticket(Request $request,$ticket)
    {
        
        try {
            $ticket = Ticket::findOrFail($ticket);
            
        } catch (\Exception $e) {
            return response()->json(['message'=>'ticket not found!'], 404);
        }


        try
        {
        $all=$request->all();
        if($ticket->complete==0)
        {
        if(!empty($all['technicians_id']))
        {
            
            foreach ($all['technicians_id'] as $tec) {
                
                $t=Ticket_technician::upsert([
                    'ticket_id' => $ticket->id,
                    'technicians_id' => $tec['id'],
                ],['ticket_id','technicians_id']);
            }
        }

        $ticket->work_hour = empty($request->work_hour) ? $ticket->work_hour : $request->work_hour;
        
        $sum=0;
        $countT = Ticket_technician::where('ticket_id','=',$ticket->id)->get();
        foreach($countT as $c)
        {
            $t=Technician::where('id','=',$c->technicians_id)->get();
            foreach($t as $tt)
            {
                $sum=$sum+$tt->hour_cost;
            }
            
            
            
        }
        $ticket->total_cost=$ticket->service->price+$countT->count()*$ticket->priority->value*$sum;
        $ticket->save();
        }
        if($ticket->complete==1)
        {
            
            $ticket->work_report = empty($request->work_report) ? $ticket->work_report : $request->work_report;
            $ticket->notes = empty($request->notes) ? $ticket->notes : $request->notes;    
            
            $ticket->save();     
        }
        
        
            if(!empty($ticket['client_id'])&&!empty($ticket['priority_id'])&&!empty($ticket['service_id']))
            {
                
                if(!empty($ticket->technicians)&&!empty($ticket->work_hour))
                {
                    if(!empty($ticket['work_report'])&&!empty($ticket['work_completion_date'])&&!empty($ticket['notes'])
                       &&!empty($ticket['total_cost'])&&!empty($ticket['evaluation_id']))
                    {
                        $ticket->update(['status_id'=>'3']);
                   
                    }
                    else
                    {
                        $ticket->update(['status_id'=>'2']);
                       
                    }
                   
                }
                else
                {
                    $ticket->update(['status_id'=>'1']);
                }
                $ticket->save();
            }
            
    
              return response()->json([$ticket]);
        }
        catch(\Exception $e)
        {
            return response()->json(['error' => $e->getMessage()]);

        }
        
    }
    
    
    public function delete_ticket($id)
    {
        try {
            $ticket = Ticket::findOrFail($id);
            
        } catch (\Exception $e) {
            return response()->json(['message'=>'ticket not found!'], 404);
        }

        
            $ticket->delete();
            return response()->json(["successful delete"]);
        
        
    }
    public function view_ticket($id)
    {
        try {
            $ticket=Ticket::where('id',$id)->firstOrFail();
            
        } catch (\Exception $e) {
            return response()->json(['message'=>'ticket not found!'], 404);
        }

        return response()->json(["id"=>$ticket->id,"client_name"=>$ticket->client->name,"service_title"=>$ticket->service->title,"status_title"=>$ticket->status->title,
                                "priority_title"=>$ticket->priority->title,"ticket_evaluation"=>$ticket->evaluation->title,"technicians"=>$ticket->technicians
                                ]);
    }

    public function technicians_pagination()
    {
        $page=Technician::Paginate(3);
        return response()->json([$page]);

    }
    public function filter_ticket()
    {
        try
        {
            $f=Ticket::orderby('created_at')->get();
            return response()->json([$f]);
    
        }
        catch(Exception $e)
        {
            return response()->json([
        
            'error' => $e->getMessage()]);
        
        }
        
    }

    public function complete_ticket($ticket)
    {
        try {
            $ticket = Ticket::findOrFail($ticket);
            
        } catch (\Exception $e) {
            return response()->json(['message'=>'ticket not found!'], 404);
        }
        if($ticket['complete']=='0')
        {
            $ticket->update(
                [
                    "complete"=>"1"
                ]
                );
                
            $time=Carbon::now();
            $ticket->update(
                [
                    "work_completion_date"=>$time
                ]
                );
            $ticket->save();       

            return response()->json(["ticket completed"]);    
        }
        
        


    }
    

}
