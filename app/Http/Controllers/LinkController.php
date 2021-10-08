<?php

namespace App\Http\Controllers;

use App\Http\Requests\LinkRequest;
use App\Http\Resources\LinkResource;
use App\Models\Link;
use App\Services\LinkService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LinkController extends Controller
{
    private LinkService $linkService;

    public function __construct(LinkService $linkService)
    {
        $this->linkService = $linkService;
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        return LinkResource::collection($this->linkService->get($request->get('limit')));
    }

    public function store(LinkRequest $request): LinkResource
    {
        return LinkResource::make($this->linkService->create($request->all()));
    }

    public function update(LinkRequest $request, Link $link): LinkResource
    {
        return LinkResource::make($this->linkService->update($link, $request->all()));
    }

    public function destroy(Link $link): JsonResponse
    {
        $this->linkService->delete($link);
        return response()->json(null, 204);
    }
}
