<?php

namespace App\Http\Controllers\Api;

use App\Models\Subscriber;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Subscriber\AddFieldsToSubscriberRequest;
use App\Http\Resources\SubscriberResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\Subscriber\CreateSubscriberRequest;
use App\Http\Requests\Subscriber\UpdateSubscriberRequest;
use App\Models\FieldSubscriber;
use Illuminate\Support\Facades\DB;

class SubscribersController extends Controller
{
    public function index()
    {
        return SubscriberResource::collection(Subscriber::paginate());
    }

    public function show(int $id)
    {
        try {
            $subscriber = Subscriber::with(['fields'])->find($id);

            if (!$subscriber) throw new ModelNotFoundException('Subscriber does not exist');

            return new SubscriberResource($subscriber);
        } catch (ModelNotFoundException $exception) {
            Log::error($exception->getTraceAsString());

            return response()->json(['message' => $exception->getMessage()], JsonResponse::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            Log::error($exception->getTraceAsString());

            return response()->json(['message' => $exception->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(CreateSubscriberRequest $request)
    {
        $subscriber = Subscriber::create($request->all());

        return new SubscriberResource($subscriber);
    }

    public function update(UpdateSubscriberRequest $request, int $id)
    {
        try {
            $subscriber = Subscriber::find($id);

            if (!$subscriber) throw new ModelNotFoundException('Subscriber does not exist');

            if ($request->name !== $subscriber->name) {
                $subscriber->name = $request->name;
            }

            if ($request->state !== $subscriber->state) {
                $subscriber->state = $request->state;
            }

            $subscriber->save();

            return new SubscriberResource($subscriber);
        } catch (ModelNotFoundException $exception) {
            Log::error($exception->getTraceAsString());

            return response()->json(['message' => $exception->getMessage()], JsonResponse::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            Log::error($exception->getTraceAsString());

            return response()->json(['message' => $exception->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function upsertFields(AddFieldsToSubscriberRequest $request, int $id)
    {
        try {
            $subscriber = Subscriber::find($id);

            if (!$subscriber) throw new ModelNotFoundException('Subsriber does not exist');

            DB::beginTransaction();

            if (empty($request->fields)) {
                FieldSubscriber::whereSubscriberId($subscriber->id)->delete();
            }

            foreach ($request->fields as $field) {
                FieldSubscriber::whereSubscriberId($subscriber->id)->delete();
                FieldSubscriber::updateOrCreate([
                    'field_id' => $field['field_id'],
                    'subscriber_id' => $subscriber->id,
                    'value' => $field['value'],
                ]);
            }

            DB::commit();

            Log::info('Fields added to subscriber');

            return response()->json(['message' => 'Fields added to subscriber'], JsonResponse::HTTP_CREATED);
        } catch (ModelNotFoundException $exception) {
            Log::error($exception->getTraceAsString());

            return response()->json(['message' => $exception->getMessage()], JsonResponse::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error($exception->getTraceAsString());

            return response()->json(['message' => $exception->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(int $id)
    {
        try {
            $subscriber = Subscriber::find($id);

            if (!$subscriber) throw new ModelNotFoundException('Subscriber not found');

            $subscriber->update(['state' => Subscriber::STATE_JUNK]);
            $subscriber->delete();

            Log::info('Subscriber deleted');

            return response()->json(['message' => 'Subscriber deleted']);
        } catch (ModelNotFoundException $exception) {
            Log::error($exception->getTraceAsString());

            return response()->json(['message' => $exception->getMessage()], JsonResponse::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            Log::error($exception->getTraceAsString());

            return response()->json(['message' => $exception->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
