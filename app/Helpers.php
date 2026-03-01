<?php

if (! function_exists('sanitize_doc_html')) {
    /**
     * Sanitize HTML content for safe display (e.g. from Trix editor).
     * Strips dangerous tags and javascript: / data: URLs in href/src.
     */
    function sanitize_doc_html(string $html): string
    {
        $allowed = '<p><br><div><span><strong><b><em><i><u><a><ul><ol><li><h1><h2><h3><h4><blockquote><pre><code><hr><figure><figcaption><img>';
        $html = strip_tags($html, $allowed);
        $html = preg_replace('/\s*href\s*=\s*["\']?\s*javascript:[^"\']*["\']?/i', ' href="#"', $html);
        $html = preg_replace('/\s*src\s*=\s*["\']?\s*javascript:[^"\']*["\']?/i', ' src=""', $html);
        $html = preg_replace('/\s*src\s*=\s*["\']?\s*data:[^"\']*["\']?/i', ' src=""', $html);

        return $html;
    }
}
