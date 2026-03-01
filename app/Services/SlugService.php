<?php

namespace App\Services;

use App\Models\Doc;
use Illuminate\Support\Str;

class SlugService
{
    /**
     * Generate a unique slug from the title.
     * Appends -2, -3, etc. if the slug already exists.
     */
    public function generateUnique(string $title, ?int $excludeDocId = null): string
    {
        $slug = Str::slug($title);
        $base = $slug;
        $n = 2;

        while ($this->slugExists($slug, $excludeDocId)) {
            $slug = $base . '-' . $n;
            $n++;
        }

        return $slug;
    }

    /**
     * Check if a slug is already used (optionally excluding a doc id for updates).
     */
    protected function slugExists(string $slug, ?int $excludeDocId = null): bool
    {
        $query = Doc::where('slug', $slug);

        if ($excludeDocId !== null) {
            $query->where('id', '!=', $excludeDocId);
        }

        return $query->exists();
    }
}
