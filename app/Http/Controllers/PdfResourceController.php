<?php

namespace App\Http\Controllers;

use App\Http\Requests\PdfResourceRequest;


use App\Http\Resources\PdfResourcesResource;
use App\Models\PdfResource;
use App\Services\PdfResourceService;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;


class PdfResourceController extends Controller
{
    private PdfResourceService $pdfResourceService;

    public function __construct(PdfResourceService $pdfResourceService)
    {
        $this->pdfResourceService = $pdfResourceService;
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        return PdfResourcesResource::collection($this->pdfResourceService->getPdfResources($request));
    }

    public function store(PdfResourceRequest $request): PdfResourcesResource
    {

        return PdfResourcesResource::make($this->pdfResourceService->createPdfResource($request));
    }

    public function update(PdfResourceRequest $request,PdfResource $pdfResource): PdfResourcesResource
    {
        return PdfResourcesResource::make($this->pdfResourceService->updatePdfResource($pdfResource, $request));
    }

    public function destroy(PdfResource $pdfResource): JsonResponse
    {
        $this->pdfResourceService->deletePdfFile($pdfResource);
        return response()->json(null, 204);
    }

    public function download(PdfResource $pdfResource): StreamedResponse
    {
        return Storage::disk('public')->download($pdfResource->path);
    }
}
