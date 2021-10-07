<?php


namespace App\Repositories;


use App\Models\PdfResource;

class PdfResourceRepository implements IResourceRepository
{

    public function get($id)
    {
        // TODO: Implement get() method.
    }

    public function create($postData)
    {
        return PdfResource::query()->create($postData);
    }

    public function update($model, $data)
    {
        $model->update($data);
        return $model->fresh();
    }

    public function list($perPage)
    {
        return PdfResource::query()->orderByDesc('id')->paginate($perPage);
    }

    public function delete($model)
    {
         return $model->delete();
    }
}