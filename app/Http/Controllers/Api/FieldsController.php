<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Field\CreateFieldRequest;
use App\Http\Resources\FieldResource;
use App\Models\Field;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class FieldsController extends Controller
{
    public function index()
    {
        return FieldResource::collection(Field::all());
    }

    public function store(CreateFieldRequest $request)
    {
        try {
            $field = Field::create($request->all());

            return new FieldResource($field);
        } catch (ValidationException $exception) {
            Log::error($exception->getTraceAsString());

            return response()->json(['message' => $exception->getMessage()], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $exception) {
            Log::error($exception->getTraceAsString());

            return response()->json(['message' => $exception->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(int $id)
    {
        try {
            $field = Field::find($id);

            if (!$field) throw new ModelNotFoundException('Field resource not found');

            return new FieldResource($field);
        } catch (ModelNotFoundException $exception) {
            Log::error($exception->getTraceAsString());

            return response()->json(['message' => $exception->getMessage()], JsonResponse::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            Log::error($exception->getTraceAsString());

            return response()->json(['message' => $exception->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(CreateFieldRequest $request, int $id)
    {
        try {
            $field = Field::find($id);

            if (!$field) throw new ModelNotFoundException('Field resource not found');

            if ($request->title !== $field->title) $field->title = $request->title;
            if ($request->type !== $field->type) $field->type = $request->type;

            $field->save();

            Log::info('Field resource updated');

            return new FieldResource($field);
        } catch (ModelNotFoundException $exception) {
            Log::error($exception->getTraceAsString());

            return response()->json(['message' => $exception->getMessage()], JsonResponse::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            Log::error($exception->getTraceAsString());

            return response()->json(['message' => $exception->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(int $id)
    {
        try {
            $field = Field::find($id);

            if (!$field) throw new ModelNotFoundException('Field resource not found');

            $field->delete();

            Log::info('Field resource deleted');

            return response()->json(['message' => 'Field resource deleted']);
        } catch (ModelNotFoundException $exception) {
            Log::error($exception->getTraceAsString());

            return response()->json(['message' => $exception->getMessage()], JsonResponse::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            Log::error($exception->getTraceAsString());

            return response()->json(['message' => $exception->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
