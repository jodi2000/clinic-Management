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
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Stmt\TryCatch;

class ClientController extends Controller
{
    public function factory_user()
    {
        
        $users = User::factory()->count(3)->make();
        
        return response()->json([$users]);
    }
    public function create_ticket(Request $request)
    {
        $id=Auth::id();
        try
        {
            $valid = Validator::make(
                $request->all(),
                [
                    'priority_id' => 'required',
                    'service_id' => 'required',
                    
                ]
            );
                if ($valid->fails())
                    return response($valid->errors());
                    
                $t=Ticket::create([
                    'client_id' => $id,
                    'priority_id' => $request->get('priority_id'),
                    'service_id' => $request->get('service_id'),
                ]);
                if($t)
                {
                    $t->update(['status_id'=>'1']);
                }
                
    
                return response()->json([$t]);
        }
        catch(\Exception $e)
        {
            return response()->json([
        
                'error' => $e->getMessage()
    
            ]);
        }
        
    }
    public function evaluate_ticket($evaluate,$ticket)
    {
        try
        {
            $ticket=Ticket::find($ticket);
            if($ticket->complete=='1')
            {
                $ticket->update([
                    "evaluation_id"=>$evaluate,
                ]);
                

            }
            if(!empty($ticket->evaluation_id)&&$ticket->evaluation->value!=0)
            {
                
                $evaluation=Evaluation::findOrFail($ticket->evaluation_id);
                $ticket->discount=$evaluation->value;
                $ticket->total_cost=$ticket->total_cost-$ticket->total_cost*$ticket->discount/100;
                $ticket->save();
                return response()->json([$ticket->evaluation->title,"you have a discount $ticket->discount%",]);
            }
           

        }
        catch(Exception $e)
        {
            return response()->json([
        
            'error' => $e->getMessage()

        ]);
        
        }
        

    }
    
}
