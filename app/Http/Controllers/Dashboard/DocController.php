<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doc\StoreDocRequest;
use App\Http\Requests\Doc\UpdateDocRequest;
use App\Models\Doc;
use App\Services\SlugService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DocController extends Controller
{
    public function __construct(
        private SlugService $slugService
    ) {}

    /**
     * List the authenticated user's docs (paginated).
     */
    public function index(Request $request): View
    {
        $docs = $request->user()
            ->docs()
            ->select(['id', 'title', 'slug', 'excerpt', 'cover_path', 'status', 'published_at', 'updated_at'])
            ->latest('updated_at')
            ->paginate(10);

        return view('dashboard.docs.index', ['docs' => $docs]);
    }

    /**
     * Show the create form.
     */
    public function create(): View
    {
        return view('dashboard.docs.create');
    }

    /**
     * Store a new doc (Form Request + SlugService + cover upload).
     */
    public function store(StoreDocRequest $request): RedirectResponse
    {
        $slug = $this->slugService->generateUnique($request->validated('title'));

        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $this->storeCoverImage($request->file('cover_image'));
        }

        $publishedAt = $request->validated('status') === 'published' ? now() : null;

        $request->user()->docs()->create([
            'title' => $request->validated('title'),
            'slug' => $slug,
            'excerpt' => $request->validated('excerpt'),
            'content' => $request->validated('content'),
            'cover_path' => $coverPath,
            'status' => $request->validated('status'),
            'published_at' => $publishedAt,
        ]);

        return redirect()
            ->route('dashboard.docs.index')
            ->with('success', 'Doc created successfully.');
    }

    /**
     * Show the edit form.
     */
    public function edit(Request $request, Doc $doc): View|RedirectResponse
    {
        $this->authorize('update', $doc);

        return view('dashboard.docs.edit', ['doc' => $doc]);
    }

    /**
     * Update the doc (Form Request, slug only if not published, cover replace).
     */
    public function update(UpdateDocRequest $request, Doc $doc): RedirectResponse
    {
        $this->authorize('update', $doc);

        $data = array_filter([
            'title' => $request->validated('title'),
            'excerpt' => $request->validated('excerpt'),
            'content' => $request->validated('content'),
            'status' => $request->validated('status'),
        ], fn ($v) => $v !== null);

        if (isset($data['title']) && $doc->status !== 'published') {
            $data['slug'] = $this->slugService->generateUnique($data['title'], $doc->id);
        }

        if ($request->hasFile('cover_image')) {
            if ($doc->cover_path) {
                Storage::disk('public')->delete($doc->cover_path);
            }
            $data['cover_path'] = $this->storeCoverImage($request->file('cover_image'));
        }

        if (isset($data['status'])) {
            $data['published_at'] = $data['status'] === 'published' ? ($doc->published_at ?? now()) : null;
        }

        $doc->update($data);

        return redirect()
            ->route('dashboard.docs.index')
            ->with('success', 'Doc updated successfully.');
    }

    /**
     * Delete the doc.
     */
    public function destroy(Request $request, Doc $doc): RedirectResponse
    {
        $this->authorize('delete', $doc);

        if ($doc->cover_path) {
            Storage::disk('public')->delete($doc->cover_path);
        }
        $doc->delete();

        return redirect()
            ->route('dashboard.docs.index')
            ->with('success', 'Doc deleted successfully.');
    }

    /**
     * Set status to published and set published_at.
     */
    public function publish(Request $request, Doc $doc): RedirectResponse
    {
        $this->authorize('publish', $doc);

        $doc->update([
            'status' => 'published',
            'published_at' => $doc->published_at ?? now(),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Doc published.');
    }

    /**
     * Set status to draft and clear published_at.
     */
    public function unpublish(Request $request, Doc $doc): RedirectResponse
    {
        $this->authorize('unpublish', $doc);

        $doc->update([
            'status' => 'draft',
            'published_at' => null,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Doc unpublished.');
    }

    /**
     * Store cover image under docs/covers; return relative path.
     */
    private function storeCoverImage(\Illuminate\Http\UploadedFile $file): string
    {
        $path = $file->store('docs/covers', 'public');

        return $path;
    }
}
