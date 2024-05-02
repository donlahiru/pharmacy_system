<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;


class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view customer'], ['only' => ['index', 'show']]);
        $this->middleware(['permission:create customer'], ['only' => ['store']]);
        $this->middleware(['permission:update customer'], ['only' => ['update']]);
        $this->middleware(['permission:delete customer'], ['only' => ['delete']]);
        $this->middleware(['permission:p_delete customer'], ['only' => ['destroy']]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */

    public function index()
    {
        $data = Customer::latest()->paginate(10);

        return response()->json([
            'status' => false,
            'data' => $data,
        ], 200);

    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function show($id)
    {
        $customer = Customer::find($id);

        return response()->json([
            'status' => false,
            'customer' => $customer,
        ], 200);
    }

    /**
     * @param StoreCustomerRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function store(StoreCustomerRequest $request)
    {
        try {

            $customer = new Customer();
            foreach ($customer->getFillable() as $key => $value) {
                switch ($value) {
                    case 'status':
                        $customer->$value = $customer::ACTIVE_STATUS;
                        break;
                    case 'created_by':
                        $customer->$value = auth()->user()->id;
                        break;
                    default:
                        $customer->$value = $request->$value;
                        break;
                }
            }

            if ($customer->save()) {
                return response()->json([
                    'status' => true,
                    'customer_id' => $customer->id,
                    'message' => 'Customer created successfully.',
                ], 200);
            }

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }

    }

    /**
     * @param UpdateCustomerRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function update(UpdateCustomerRequest $request, $id)
    {
        try {
            $customer = Customer::find($id);

            foreach ($customer->getFillable() as $key => $value) {
                switch ($value) {
                    case 'updated_by':
                        $customer->$value = auth()->user()->id;
                        break;
                    default:
                        $customer->$value = $request->$value ? $request->$value : $customer->$value;
                        break;
                }
            }

            if ($customer->save()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Customer updated successfully.',
                ], 200);
            }

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function delete($id)
    {
        try {
            Customer::find($id)->delete();

            return response()->json([
                'status' => true,
                'message' => 'Customer deleted successfully.',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }

    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function destroy($id)
    {
        try {
            Customer::withTrashed()->find($id)->forceDelete();

            return response()->json([
                'status' => true,
                'message' => 'Customer permanently deleted successfully.',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
