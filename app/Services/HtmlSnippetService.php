<?php


namespace App\Services;


use App\Models\HtmlSnippet;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class HtmlSnippetService implements IResourceService
{

    public function get($limit): LengthAwarePaginator
    {
        return HtmlSnippet::query()->orderByDesc('id')->paginate($limit);
    }

    public function create($postData): Model|Builder
    {
        return HtmlSnippet::query()->create($postData);
    }

    public function update($htmlSnippet, $putData)
    {
        $htmlSnippet->update($putData);
        return $htmlSnippet->fresh();
    }

    public function delete($htmlSnippet)
    {
        return $htmlSnippet->delete();
    }


}