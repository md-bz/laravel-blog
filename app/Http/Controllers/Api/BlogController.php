<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
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
        ]);
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
        $blog = Blog::create($data);

        return response()->json([
            'success' => true,
            'data' => $blog,
            'message' => 'Blog created successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog): JsonResponse
    {
        $blog->load('author');

        return response()->json([
            'success' => true,
            'data' => $blog,
            'message' => 'Blog retrieved successfully'
        ]);
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
        ]);
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
