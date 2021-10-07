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
        return HtmlSnippetResource::collection($this->htmlSnippetService->getHtmlSnippets($request));
    }

    public function store(HtmlSnippetRequest $request): HtmlSnippetResource
    {
        return HtmlSnippetResource::make($this->htmlSnippetService->createHtmlSnippet($request));
    }

    public function update(HtmlSnippetRequest $request, HtmlSnippet $htmlSnippet): HtmlSnippetResource
    {
        return HtmlSnippetResource::make($this->htmlSnippetService->updateHtmlSnippet($htmlSnippet, $request));
    }

    public function destroy(HtmlSnippet $htmlSnippet): JsonResponse
    {
        $this->htmlSnippetService->deleteHtmlSnippet($htmlSnippet);
        return response()->json(null, 204);
    }


}
