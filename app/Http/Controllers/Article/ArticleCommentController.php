<?php

namespace App\Http\Controllers\Article;

use Illuminate\Routing\Controller as BaseController;
use App\Models\Article\Article;
use App\Models\Article\ArticleComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleCommentController extends BaseController
{
    /** POST /article/{article}/comments */
    public function store(Request $request, Article $article)
    {
        $request->validate([
            'body'      => 'required|string|max:2000',
            'parent_id' => 'nullable|integer|exists:article_comments,id',
        ]);

        if ($request->parent_id) {
            $parent = ArticleComment::findOrFail($request->parent_id);
            abort_if($parent->article_id !== $article->id, 422, 'Invalid parent comment.');
        }

        ArticleComment::create([
            'article_id' => $article->id,
            'user_id'    => Auth::id(),
            'parent_id'  => $request->parent_id,
            'body'       => $request->body,
        ]);

        $anchor = $request->parent_id ? '#comment-' . $request->parent_id : '#comments';

        return redirect(route('articles.detail', $article->id) . $anchor)
            ->with('success', 'Komentar berhasil ditambahkan!');
    }

    /** PUT /article/comments/{comment} */
    public function update(Request $request, ArticleComment $comment)
    {
        abort_if($comment->user_id !== Auth::id(), 403, 'Unauthorized.');

        $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        $comment->update(['body' => $request->body]);

        return redirect(route('articles.detail', $comment->article_id) . '#comment-' . $comment->id)
            ->with('success', 'Komentar berhasil diperbarui!');
    }

    /** DELETE /article/comments/{comment} */
    public function destroy(ArticleComment $comment)
    {
        $isOwner = $comment->user_id === Auth::id();
        $isAdmin = in_array(Auth::user()->role, ['admin', 'superadmin']);

        abort_if(!$isOwner && !$isAdmin, 403, 'Unauthorized.');

        $comment->delete();

        return redirect(route('articles.detail', $comment->article_id) . '#comments')
            ->with('success', 'Komentar berhasil dihapus!');
    }
}