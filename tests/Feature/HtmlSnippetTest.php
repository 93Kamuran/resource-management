<?php

namespace Tests\Feature;

use App\Models\HtmlSnippet;
use Carbon\Carbon;
use Database\Factories\HtmlSnippetFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HtmlSnippetTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_post_a_html_snippet()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/api/html-snippets', [
            'title' => 'Snippet',
            'description' => 'testing description',
            'html' => '<p>test</p>'
        ]);
        $recentlyHtmlSnippet = HtmlSnippet::query()->latest()->first();
        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'id' => $recentlyHtmlSnippet->id,
                    'type' => 'html-snippets',
                    'attributes' => [
                        'title' => 'Snippet',
                        'description' => 'testing description',
                        'html' => '<p>test</p>',
                        'created' => Carbon::parse($recentlyHtmlSnippet->created_at)->format('Y-m-d H:i:s'),
                        'modified' => Carbon::parse($recentlyHtmlSnippet->updated_at)->format('Y-m-d H:i:s')
                    ]
                ],
                'links' => [
                    'self' => url('/html-snippets/' . $recentlyHtmlSnippet->id),
                ]
            ]);
    }

    public function test_admin_can_update_a_html_snippet()
    {
        $this->withoutExceptionHandling();
        $earlyCreatedHtmlSnippet = HtmlSnippetFactory::new()->create([
            'title' => 'Snippet',
            'description' => 'testing description',
            'html' => '<p>test</p>'
        ]);

        $response = $this->put(sprintf('/api/html-snippets/%s', $earlyCreatedHtmlSnippet->id), [
            'title' => 'Snippet',
            'description' => 'testing description',
            'html' => '<p>test</p>'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $earlyCreatedHtmlSnippet->id,
                    'type' => 'html-snippets',
                    'attributes' => [
                        'title' => 'Snippet',
                        'description' => 'testing description',
                        'html' => '<p>test</p>',
                        'created' => Carbon::parse($earlyCreatedHtmlSnippet->created_at)->format('Y-m-d H:i:s'),
                        'modified' => Carbon::parse($earlyCreatedHtmlSnippet->updated_at)->format('Y-m-d H:i:s')
                    ]
                ],
                'links' => [
                    'self' => url('/html-snippets/' . $earlyCreatedHtmlSnippet->id),
                ]
            ]);
    }

    public function test_admin_can_delete_a_html_snippet()
    {
        $this->withoutExceptionHandling();
        $createdHtmlSnippet = HtmlSnippetFactory::new()->create([
            'title' => 'Snippet',
            'description' => 'testing description',
            'html' => '<p>test</p>'
        ]);
        $response = $this->delete(sprintf('/api/html-snippets/%s', $createdHtmlSnippet->id));
        $response->assertStatus(204);
    }

    public function test_admin_or_user_can_retrieve_html_snippet()
    {

        $firstCreatedHtmlSnippet = HtmlSnippetFactory::new()->create([
            'title' => 'Snippet First',
            'description' => 'first description',
            'html' => '<p>test</p>'
        ]);
        $lastCreatedHtmlSnippet = HtmlSnippetFactory::new()->create([
            'title' => 'Snippet Last',
            'description' => 'last description',
            'html' => '<p>test</p>'
        ]);
        $response = $this->get('/api/html-snippets?limit=2&page=1');
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'data' => [
                            'type' => 'html-snippets',
                            'id' => $lastCreatedHtmlSnippet->id,
                            'attributes' => [
                                'title' => $lastCreatedHtmlSnippet->title,
                                'description' => $lastCreatedHtmlSnippet->description,
                                'html' => $lastCreatedHtmlSnippet->html,
                                'created' => Carbon::parse($lastCreatedHtmlSnippet->created_at)->format('Y-m-d H:i:s'),
                                'modified' => Carbon::parse($lastCreatedHtmlSnippet->updated_at)->format('Y-m-d H:i:s')
                            ]
                        ],
                        'links' => [
                            'self' => url('/html-snippets/' . $lastCreatedHtmlSnippet->id),
                        ]
                    ],
                    [
                        'data' => [
                            'type' => 'html-snippets',
                            'id' => $firstCreatedHtmlSnippet->id,
                            'attributes' => [
                                'title' => $firstCreatedHtmlSnippet->title,
                                'description' => $firstCreatedHtmlSnippet->description,
                                'html' => $firstCreatedHtmlSnippet->html,
                                'created' => Carbon::parse($firstCreatedHtmlSnippet->created_at)->format('Y-m-d H:i:s'),
                                'modified' => Carbon::parse($firstCreatedHtmlSnippet->updated_at)->format('Y-m-d H:i:s')
                            ]
                        ],
                        'links' => [
                            'self' => url('/html-snippets/' . $firstCreatedHtmlSnippet->id),
                        ]
                    ]
                ]
            ]);
    }
}
