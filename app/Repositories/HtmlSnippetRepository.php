<?php


namespace App\Repositories;


use App\Models\HtmlSnippet;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class HtmlSnippetRepository implements IResourceRepository
{

    public function list($perPage): LengthAwarePaginator
    {
        return HtmlSnippet::query()->orderByDesc('id')->paginate($perPage);
    }

    public function get($id)
    {
        // TODO: Implement get() method.
    }

    public function create($postData): Model
    {
        return HtmlSnippet::query()->create($postData);
    }

    public function update($model, $data)
    {
        $model->update($data);
        return $model->fresh();
    }

    public function delete($model)
    {
        return $model->delete();
    }
}