<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TaskService;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function checkTask()
    {
        $result = $this->taskService->checkBirthdayTask();

        return response()->json([
            'message'=> "queue created!",
            'data'=>$result
        ]);
    }

    public function sendTask()
    {
        $result = $this->taskService->sendTask();

        return response()->json([
            'message'=> "queue created!",
            'data'=>$result
        ]);
    }
}
