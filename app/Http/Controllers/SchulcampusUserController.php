<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchSchulcampusUsersRequest;
use App\Http\Resources\SchulcampusUserResource;
use App\Models\SchulcampusUser;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class SchulcampusUserController extends Controller
{
    public function index(): View
    {
        return view('users.index');
    }

    public function fetch(SearchSchulcampusUsersRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $search = $validated['search'] ?? '';

        return is_string($search) ?
            response()->json(
                SchulcampusUserResource::collection(
                    SchulcampusUser::query()
                        ->select('id', 'username', 'given_name', 'family_name')
                        ->search($search)
                        ->limit(8)
                        ->get()
                ),
                200
            ) :
            response()->json(null, 200);
    }

    public function show(SchulcampusUser $user): View
    {
        return view('users.show', [
            'user' => $user,
        ]);
    }
}
