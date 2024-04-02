<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchSchulcampusUsersRequest;
use App\Http\Resources\SchulcampusUserResource;
use App\Models\SchulcampusUser;
use Illuminate\Http\JsonResponse;

class SchulcampusUserController extends Controller
{
    public function query(SearchSchulcampusUsersRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $search = $validated['search'] ?? '';
        /** @var int */
        $offset = $validated['offset'] ?? 0;
        /** @var int */
        $amount = $validated['amount'] ?? 8;

        return is_string($search) ?
            response()->json(
                SchulcampusUserResource::collection(
                    SchulcampusUser::query()
                        ->select('id', 'given_name', 'family_name')
                        ->search($search)
                        ->orderBy('given_name')
                        ->orderBy('family_name')
                        ->skip($offset)
                        ->limit($amount)
                        ->get()
                ),
                200
            ) :
            response()->json(null, 200);
    }

    public function show(SchulcampusUser $user): JsonResponse
    {
        return response()->json(new SchulcampusUserResource($user));
    }
}
