<?php

namespace Tests\Feature;

use App\Models\Link;
use Carbon\Carbon;
use Database\Factories\LinkFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class LinkTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_post_a_link()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/api/links', [
            'title' => 'Link',
            'link' => 'https://test.com',
            'target' => '_blank'
        ]);
        $recentlyCreatedLink = Link::query()->latest()->first();
        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'id' => $recentlyCreatedLink->id,
                    'type' => 'links',
                    'attributes' => [
                        'title' => 'Link',
                        'link' => 'https://test.com',
                        'target' => '_blank',
                        'created' => Carbon::parse($recentlyCreatedLink->created_at)->format('Y-m-d H:i:s'),
                        'modified' => Carbon::parse($recentlyCreatedLink->updated_at)->format('Y-m-d H:i:s')
                    ]
                ],
                'links' => [
                    'self' => url('/links/' . $recentlyCreatedLink->id),
                ]
            ]);
    }

    public function test_admin_can_update_a_link()
    {
        $this->withoutExceptionHandling();
        $earlyCreatedLink = LinkFactory::new()->create([
            'title' => 'Link',
            'link' => 'https://test.com',
            'target' => '_blank'
        ]);

        $response = $this->put(sprintf('/api/links/%s', $earlyCreatedLink->id), [
            'title' => 'Link',
            'link' => 'https://test.com',
            'target' => '_self'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $earlyCreatedLink->id,
                    'type' => 'links',
                    'attributes' => [
                        'title' => 'Link',
                        'link' => 'https://test.com',
                        'target' => '_self',
                        'created' => Carbon::parse($earlyCreatedLink->created_at)->format('Y-m-d H:i:s'),
                        'modified' => Carbon::parse($earlyCreatedLink->updated_at)->format('Y-m-d H:i:s')
                    ]
                ],
                'links' => [
                    'self' => url('/links/' . $earlyCreatedLink->id),
                ]
            ]);
    }

    public function test_admin_can_delete_a_link()
    {
        $this->withoutExceptionHandling();
        $earlyCreatedLink = LinkFactory::new()->create([
            'title' => 'Link',
            'link' => 'https://test.com',
            'target' => '_blank'
        ]);
        $response = $this->delete(sprintf('/api/links/%s', $earlyCreatedLink->id));
        $response->assertStatus(204);
    }

    public function test_admin_or_user_can_retrieve_links()
    {

        $firstCreatedLink = LinkFactory::new()->create([
            'title' => 'First Link',
            'link' => 'https://first.com',
            'target' => '_blank'
        ]);
        $lastCreatedLink = LinkFactory::new()->create([
            'title' => 'Last Link',
            'link' => 'https://last.com',
            'target' => '_self'
        ]);
        $response = $this->get('/api/links?limit=2&page=1');
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'data' => [
                            'type' => 'links',
                            'id' => $lastCreatedLink->id,
                            'attributes' => [
                                'title' => $lastCreatedLink->title,
                                'link' => $lastCreatedLink->link,
                                'target' => $lastCreatedLink->target,
                                'created' => Carbon::parse($lastCreatedLink->created_at)->format('Y-m-d H:i:s'),
                                'modified' => Carbon::parse($lastCreatedLink->updated_at)->format('Y-m-d H:i:s')
                            ]
                        ],
                        'links' => [
                            'self' => url('/links/' . $lastCreatedLink->id),
                        ]
                    ],
                    [
                        'data' => [
                            'type' => 'links',
                            'id' => $firstCreatedLink->id,
                            'attributes' => [
                                'title' => $firstCreatedLink->title,
                                'link' => $firstCreatedLink->link,
                                'target' => $firstCreatedLink->target,
                                'created' => Carbon::parse($firstCreatedLink->created_at)->format('Y-m-d H:i:s'),
                                'modified' => Carbon::parse($firstCreatedLink->updated_at)->format('Y-m-d H:i:s')
                            ]
                        ],
                        'links' => [
                            'self' => url('/links/' . $firstCreatedLink->id),
                        ]
                    ]
                ]
            ]);
    }
}
