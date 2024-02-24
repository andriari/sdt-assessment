<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Queue;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class TaskService
{
    protected $customer;
    protected $queue;

    public function __construct(Customer $customer, Queue $queue)
    {
        $this->customer = $customer;
        $this->queue = $queue;
    }

    public function checkBirthdayTask()
    {
        $now = now();
        
        $userBirthday = $this->customer->whereDay('dob', $now->day)
            ->whereMonth('dob', $now->month)
        ->get();

        $this->queueTask('Birthday-'.$now->year,$userBirthday);
    }

    protected function queueTask($type, $users){
        $timezone = config('app.timezone');

        foreach ($users as $user) {
            $userDateTime = Carbon::createFromFormat('H:i', '09:00', $user->current_timezone);
            $userUtcTime = $userDateTime->setTimezone($timezone);
            $scheduled_at = $userUtcTime->toDatetimeString();

            $this->queue->updateOrCreate([
                'customer_id' => $user->id,
                'type' => $type
            ],[
                'customer_id' => $user->id,
                'type' => $type,
                'email' => $user->email,
                'message' => "Hey, ".$user->name." it's your birthday!",
                'scheduled_at' => $scheduled_at
            ]);
        }
    }

    public function sendTask(){
        $now = date('Y-m-d H:i:s');
        
        $tasks = $this->queue->where('scheduled_at','<=',$now)->whereNull('sent_at')->take(100)->get();
        
        $ids = array();
        foreach ($tasks as $task) {
            $response = Http::post('https://email-service.digitalenvision.com.au/send-email', [
                "email" => $task->email,
                "message" => $task->message
            ]); 
            if($response->status()==200){
                array_push($ids, $task->id);
            }
        }

        if(count($ids)>0){
            $this->queue->whereIn('id', $ids)->update([
                "sent_at" => date('Y-m-d H:i:s')
            ]);
        }
    }   
}