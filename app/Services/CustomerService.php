<?php

namespace App\Services;

use App\Http\Resources\CustomerResource;
use App\Models\Customer;

class CustomerService
{
    protected $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function getAll()
    {
        $list = $this->customer->get();
        return CustomerResource::collection($list);
    }

    public function getById($id)
    {
        $detail = $this->customer->findOrFail($id);
        return new CustomerResource($detail);
    }

    public function store($request)
    {
        $this->customer->create([
            'name' => $request['name'],
            'email' => $request['email'],
            'location' => $request['location'],
            'current_timezone' => $request['current_timezone'],
            'dob' => date('Y-m-d', strtotime($request['dob'])),
        ]);
    }

    public function destroy($id)
    {
        $this->customer->findOrFail($id)->delete();
    }

    public function update($request, $id)
    {
        $this->customer->findOrFail($id)->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'location' => $request['location'],
            'current_timezone' => $request['current_timezone'],
            'dob' => date('Y-m-d', strtotime($request['dob'])),
        ]);
    }
}