<?php

namespace App\Http\Controllers;

use App\Http\Requests\HtmlSnippetRequest;
use App\Http\Resources\HtmlSnippetResource;
use App\Models\HtmlSnippet;
use App\Services\HtmlSnippetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class HtmlSnippetController extends Controller
{
    private HtmlSnippetService $htmlSnippetService;

    public function __construct(HtmlSnippetService $htmlSnippetService)
    {
        $this->htmlSnippetService = $htmlSnippetService;
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        return HtmlSnippetResource::collection($this->htmlSnippetService->get($request->get('limit')));
    }

    public function store(HtmlSnippetRequest $request): HtmlSnippetResource
    {
        return HtmlSnippetResource::make($this->htmlSnippetService->create($request->all()));
    }

    public function update(HtmlSnippetRequest $request, HtmlSnippet $htmlSnippet): HtmlSnippetResource
    {
        return HtmlSnippetResource::make($this->htmlSnippetService->update($htmlSnippet, $request->all()));
    }

    public function destroy(HtmlSnippet $htmlSnippet): JsonResponse
    {
        $this->htmlSnippetService->delete($htmlSnippet);
        return response()->json(null, 204);
    }


}
