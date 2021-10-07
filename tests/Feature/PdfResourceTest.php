<?php

namespace Tests\Feature;

use App\Models\PdfResource;
use Carbon\Carbon;
use Database\Factories\PdfResourceFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PdfResourceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }


    public function test_admin_can_post_a_pdf_resource()
    {
        $this->withoutExceptionHandling();
        $file = UploadedFile::fake()->create('test.pdf');
        $response = $this->post('/api/pdf-resources', [
            'title' => 'Testing Title',
            'file' => $file,
        ]);
        Storage::disk('public')->assertExists('pdf-files/' . $file->hashName());
        $recentlyCreatedFile = PdfResource::query()->first();

        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'id' => $recentlyCreatedFile->id,
                    'type' => 'pdf-resources',
                    'attributes' => [
                        'title' => 'Testing Title',
                        'file' => url('pdf-files/' . $file->hashName()),
                        'created' => Carbon::parse($recentlyCreatedFile->created_at)->format('Y-m-d H:i:s'),
                        'modified' => Carbon::parse($recentlyCreatedFile->updated_at)->format('Y-m-d H:i:s')
                    ]
                ],
                'links' => [
                    'self' => url('/pdf-resources/' . $recentlyCreatedFile->id),
                ]
            ]);
    }

    public function test_admin_can_update_a_pdf_resource()
    {
        $this->withoutExceptionHandling();
        $earlyCreatedFile = PdfResourceFactory::new()->create([
            'title' => 'Testing File',
            'path' => 'pdf-files/test.pdf'
        ]);
        $newFile = UploadedFile::fake()->create('test-update.pdf');
        $newFilepath = $newFile->store('pdf-files', 'public');

        $response = $this->post(sprintf('/api/pdf-resources/%s', $earlyCreatedFile->id), [
            'title' => 'Updated Title',
            'file' => $newFile,
        ]);
        Storage::disk('public')->assertMissing($earlyCreatedFile->path);
        Storage::disk('public')->assertExists($newFilepath);
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $earlyCreatedFile->id,
                    'type' => 'pdf-resources',
                    'attributes' => [
                        'title' => 'Updated Title',
                        'file' => url($newFilepath),
                        'created' => Carbon::parse($earlyCreatedFile->created_at)->format('Y-m-d H:i:s'),
                        'modified' => Carbon::parse($earlyCreatedFile->updated_at)->format('Y-m-d H:i:s')
                    ]
                ],
                'links' => [
                    'self' => url('/pdf-resources/' . $earlyCreatedFile->id),
                ]
            ]);
    }

    public function test_admin_can_delete_a_pdf_resource()
    {
        $this->withoutExceptionHandling();
        $file = UploadedFile::fake()->create('test.pdf');
        $path = $file->store('pdf-files', 'public');
        $createdFile = PdfResourceFactory::new()->create(['title' => 'Testing File', 'path' => $path]);
        $response = $this->delete(sprintf('/api/pdf-resources/%s', $createdFile->id));
        Storage::disk('public')->assertMissing($path);
        $response->assertStatus(204);
    }

    public function test_admin_or_user_can_download_a_pdf_resource()
    {
        $file = UploadedFile::fake()->create('test.pdf');
        $path = $file->store('pdf-files', 'public');
        $createdFile = PdfResourceFactory::new()->create(['title' => 'Testing File', 'path' => $path]);
        $response = $this->get(sprintf('/api/pdf-resources/%s', $createdFile->id));
        $response->assertSuccessful();
        $response->assertOk();
    }

    public function test_admin_or_user_can_retrieve_pdf_resources()
    {
        $firstFile = UploadedFile::fake()->create('test-file-first.pdf');
        $firstFilePath = $firstFile->store('pdf-files', 'public');
        PdfResourceFactory::new()->create(['title' => 'Testing File First', 'path' => $firstFilePath]);

        $lastFile = UploadedFile::fake()->create('test-file-second.pdf');
        $lastFilePath = $lastFile->store('pdf-files', 'public');
        $lastCreatedFile = PdfResourceFactory::new()->create([
            'title' => 'Testing File Second',
            'path' => $lastFilePath
        ]);
        $response = $this->get('/api/pdf-resources?limit=1&page=1');
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'data' => [
                            'type' => 'pdf-resources',
                            'id' => $lastCreatedFile->id,
                            'attributes' => [
                                'title' => $lastCreatedFile->title,
                                'file' => url($lastCreatedFile->path),
                                'created' => Carbon::parse($lastCreatedFile->created_at)->format('Y-m-d H:i:s'),
                                'modified' => Carbon::parse($lastCreatedFile->updated_at)->format('Y-m-d H:i:s')
                            ]
                        ],
                        'links' => [
                            'self' => url('/pdf-resources/' . $lastCreatedFile->id),
                        ]
                    ],
                ]
            ]);
    }
}
