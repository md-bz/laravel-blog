<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Comment;
use App\Services\Formatting\FormatterFactory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class BlogController extends Controller implements HasMiddleware

{

    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show'])
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $blogs = Blog::query()->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $blogs,
            'message' => 'Blogs retrieved successfully'
        ], 200, [], JSON_UNESCAPED_SLASHES);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'content' => ['required', 'string'],
            'title' => ['required', 'string']
        ]);

        $data['author_id'] = $request->user()->id;

        $formatter = FormatterFactory::make('mention');
        $data['content'] = $formatter->format($data['content']);

        $blog = Blog::create($data);

        logger($blog->content);
        return response()->json([
            'success' => true,
            'data' => $blog,
            'message' => 'Blog created successfully'
        ], 201, [], JSON_UNESCAPED_SLASHES);
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog): JsonResponse
    {
        $blog->load('author');
        $comments = Comment::where('blog_id', $blog->id)->get();
        $blog->comments = $comments;

        return response()->json([
            'success' => true,
            'data' => $blog,
            'message' => 'Blog retrieved successfully'
        ], 200, [], JSON_UNESCAPED_SLASHES);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog): JsonResponse
    {
        if ($blog->author_id != $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to update this blog'
            ], 403);
        }

        $data = $request->validate([
            'content' => ['required', 'string'],
            'title' => ['required', 'string']

        ]);

        $blog->update($data);

        return response()->json([
            'success' => true,
            'data' => $blog,
            'message' => 'Blog updated successfully'
        ], 200, [], JSON_UNESCAPED_SLASHES);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog): JsonResponse
    {
        if ($blog->author_id != request()->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to delete this blog'
            ], 403);
        }

        $blog->delete();

        return response()->json([
            'success' => true,
            'message' => 'Blog deleted successfully'
        ]);
    }
}
