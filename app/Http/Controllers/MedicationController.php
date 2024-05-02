<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMedicationRequest;
use App\Http\Requests\UpdateMedicationRequest;
use App\Models\Medication;

class MedicationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view medication'], ['only' => ['index', 'show']]);
        $this->middleware(['permission:create medication'], ['only' => ['store']]);
        $this->middleware(['permission:update medication'], ['only' => ['update']]);
        $this->middleware(['permission:delete medication'], ['only' => ['delete']]);
        $this->middleware(['permission:p_delete medication'], ['only' => ['destroy']]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */

    public function index()
    {
        $data = Medication::latest()->paginate(10);

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
        $medication = Medication::find($id);

        return response()->json([
            'status' => false,
            'medication' => $medication,
        ], 200);
    }

    /**
     * @param StoreMedicationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function store(StoreMedicationRequest $request)
    {
        try {
            $medication = new Medication();
            foreach ($medication->getFillable() as $key => $value) {
                switch ($value) {
                    case 'status':
                        $medication->$value = $medication::ACTIVE_STATUS;
                        break;
                    case 'created_by':
                        $medication->$value = auth()->user()->id;
                        break;
                    default:
                        $medication->$value = $request->$value;
                        break;
                }
            }

            if ($medication->save()) {
                return response()->json([
                    'status' => true,
                    'medication_id' => $medication->id,
                    'message' => 'Medication created successfully.',
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
     * @param UpdateMedicationRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function update(UpdateMedicationRequest $request, $id)
    {
        try {
            $medication = Medication::find($id);

            foreach ($medication->getFillable() as $key => $value) {
                switch ($value) {
                    case 'updated_by':
                        $medication->$value = auth()->user()->id;
                        break;
                    default:
                        $medication->$value = $request->$value ? $request->$value : $medication->$value;
                        break;
                }
            }

            if ($medication->save()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Medication updated successfully.',
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
            Medication::find($id)->delete();

            return response()->json([
                'status' => true,
                'message' => 'Medication deleted successfully.',
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
            Medication::withTrashed()->find($id)->forceDelete();

            return response()->json([
                'status' => true,
                'message' => 'Medication permanently deleted successfully.',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
