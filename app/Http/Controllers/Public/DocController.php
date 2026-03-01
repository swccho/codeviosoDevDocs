<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Doc;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DocController extends Controller
{
    /**
     * Show a published doc by slug. 404 if not found or not published.
     */
    public function show(Request $request, string $slug): View
    {
        $doc = Doc::query()
            ->published()
            ->with('user:id,name')
            ->where('slug', $slug)
            ->firstOrFail();

        return view('public.docs.show', ['doc' => $doc]);
    }
}
