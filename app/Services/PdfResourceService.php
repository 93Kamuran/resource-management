<?php


namespace App\Services;


use App\Models\PdfResource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PdfResourceService implements IResourceService
{

    public function get($limit): LengthAwarePaginator
    {
        return PdfResource::query()->orderByDesc('id')->paginate($limit);
    }

    public function create($postData): Model|Builder
    {
        $path = $postData['file']->store('pdf-files', 'public');
        return PdfResource::query()->create(['title' => $postData['title'], 'path' => $path]);

    }

    public function update($pdfResource, $putData)
    {
        Storage::disk('public')->delete($pdfResource->path);
        $path = $putData['file']->store('pdf-files', 'public');
        $pdfResource->update(['title' => $putData['title'], 'path' => $path]);
        return $pdfResource->fresh();
    }

    public function delete($pdfResource)
    {
        Storage::disk('public')->delete($pdfResource->path);
        return $pdfResource->delete();
    }
}