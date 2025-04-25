<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Http\Resources\AuthorResource;
use App\Services\AuthorService;

class AuthorController extends Controller
{
    public function __construct(private AuthorService $service) {}

    public function index()
    {
        return AuthorResource::collection($this->service->all());
    }

    public function store(StoreAuthorRequest $request)
    {
        $data = $request->validate();

        return new AuthorResource($this->service->create($data));
    }

    public function show($id)
    {
        return new AuthorResource($this->service->find($id));
    }

    public function update(UpdateAuthorRequest $request, $id)
    {
        $data = $request->validated();

        return new AuthorResource($this->service->update($id, $data));
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return response()->noContent();
    }
}
