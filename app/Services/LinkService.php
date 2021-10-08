<?php


namespace App\Services;


use App\Models\Link;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class LinkService implements IResourceService
{

    public function get($limit): LengthAwarePaginator
    {
        return Link::query()->orderByDesc('id')->paginate($limit);
    }

    public function create($postData): Builder|Model
    {
        return Link::query()->create($postData);
    }

    public function update($link, $putData): Builder|Model
    {
        $link->update($putData);
        return $link->fresh();
    }

    public function delete($link)
    {
        return $link->delete();
    }
}