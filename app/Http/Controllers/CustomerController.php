<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CustomerService;
use App\Http\Requests\Customer\StoreRequest;
use App\Http\Requests\Customer\UpdateRequest;

class CustomerController extends Controller
{
    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function index()
    {
        $result = $this->customerService->getAll();

        return response()->json($result);
    }

    public function show($id)
    {
        $result = $this->customerService->getById($id);

        return response()->json($result);
    }

    public function store(StoreRequest $request)
    {
        $result = $this->customerService->store($request);

        return response()->json([
            'message'=> "success!"
        ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        $result = $this->customerService->update($request, $id);

        return response()->json([
            'message'=> "success!"
        ]);
    }
}
