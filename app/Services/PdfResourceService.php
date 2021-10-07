<?php


namespace App\Services;


use App\Repositories\PdfResourceRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PdfResourceService
{

    private PdfResourceRepository $pdfFileRepository;

    public function __construct(PdfResourceRepository $pdfFileRepository)
    {
        $this->pdfFileRepository = $pdfFileRepository;
    }

    public function getPdfResources($request): LengthAwarePaginator
    {
        $limit = $request->get('limit');
        return $this->pdfFileRepository->list($limit);
    }


    public function createPdfResource($postData): Model|Builder
    {
        $path = $postData['file']->store('pdf-files', 'public');
        return $this->pdfFileRepository->create(['title' => $postData['title'], 'path' => $path]);
    }

    public function updatePdfResource($pdfResource, $postData)
    {
        Storage::disk('public')->delete($pdfResource->path);
        $path = $postData['file']->store('pdf-files', 'public');
        return $this->pdfFileRepository->update($pdfResource, ['title' => $postData['title'], 'path' => $path]);
    }

    public function deletePdfFile($pdfFile)
    {
        Storage::disk('public')->delete($pdfFile->path);
        return $this->pdfFileRepository->delete($pdfFile);
    }
}