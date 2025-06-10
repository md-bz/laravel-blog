<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function createPdf(Blog $blog)
    {
        $blog->load('author');
        $data = [
            'date' => $blog->created_at,
            'author' => $blog->author->name,
            'title' => $blog->title,
            'content' => $blog->content,
        ];

        $pdf = PDF::loadView('pdf', $data);

        return $pdf->stream();
    }
}
