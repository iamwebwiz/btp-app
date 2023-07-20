<?php

namespace App\Http\Controllers\Api;

use App\Models\Field;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\FieldResource;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Field\CreateFieldRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

    public function update(Request $request, int $id)
    {
        try {
            $field = Field::find($id);

            if (!$field) throw new ModelNotFoundException('Field resource not found');

            $validation = validator($request->all(), [
                'title' => 'required|string|min:3|unique:fields,id',
                'type' => ['required', 'string', Rule::in([
                    Field::TYPE_STRING,
                    Field::TYPE_NUMBER,
                    Field::TYPE_BOOLEAN,
                    Field::TYPE_DATE,
                ])],
            ]);

            if ($validation->failed()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validation->errors(),
                ], 403);
            }

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
