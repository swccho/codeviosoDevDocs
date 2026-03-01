<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Doc;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Homepage: published docs only, optional search (title + excerpt), paginated, latest first.
     */
    public function __invoke(Request $request): View
    {
        $search = $request->query('search');

        $docs = Doc::query()
            ->published()
            ->select(['id', 'user_id', 'title', 'slug', 'excerpt', 'cover_path', 'status', 'published_at', 'updated_at'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%')
                        ->orWhere('excerpt', 'like', '%' . $search . '%');
                });
            })
            ->with('user:id,name')
            ->orderByDesc('published_at')
            ->paginate(10);

        return view('public.home', [
            'docs' => $docs,
            'search' => $search,
        ]);
    }
}
