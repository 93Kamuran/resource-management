<?php


namespace App\Services;


use App\Repositories\HtmlSnippetRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class HtmlSnippetService
{
    private HtmlSnippetRepository $htmlSnippetRepository;

    public function __construct(HtmlSnippetRepository $htmlSnippetRepository)
    {
        $this->htmlSnippetRepository = $htmlSnippetRepository;
    }

    public function createHtmlSnippet($postData): Model|Builder
    {
        return $this->htmlSnippetRepository->create($postData->all());
    }

    public function updateHtmlSnippet($htmlSnippet, $postData)
    {
        return $this->htmlSnippetRepository->update($htmlSnippet, $postData->all());
    }

    public function deleteHtmlSnippet($htmlSnippet)
    {
        return $this->htmlSnippetRepository->delete($htmlSnippet);
    }

    public function getHtmlSnippets($request): LengthAwarePaginator
    {
        $limit = $request->get('limit');
        return $this->htmlSnippetRepository->list($limit);
    }
}