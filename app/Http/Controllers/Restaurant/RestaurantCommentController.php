<?php

namespace App\Http\Controllers\Restaurant;

use Illuminate\Routing\Controller as BaseController;
use App\Models\Restaurant\Restaurant;
use App\Models\Restaurant\RestaurantComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestaurantCommentController extends BaseController
{
    /** POST /restoran/{restaurant}/comments */
    public function store(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'body'      => 'required|string|max:2000',
            'parent_id' => 'nullable|integer|exists:restaurant_comments,id',
        ]);

        if ($request->parent_id) {
            $parent = RestaurantComment::findOrFail($request->parent_id);
            abort_if($parent->restaurant_id !== $restaurant->id, 422, 'Invalid parent comment.');
        }

        RestaurantComment::create([
            'restaurant_id' => $restaurant->id,
            'user_id'       => Auth::id(),
            'parent_id'     => $request->parent_id,
            'body'          => $request->body,
        ]);

        $anchor = $request->parent_id ? '#comment-' . $request->parent_id : '#comments';

        return redirect(route('restaurants.detail', $restaurant->id) . $anchor)
            ->with('success', 'Komentar berhasil ditambahkan!');
    }

    /** PUT /restoran/comments/{comment} */
    public function update(Request $request, RestaurantComment $comment)
    {
        abort_if($comment->user_id !== Auth::id(), 403, 'Unauthorized.');

        $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        $comment->update(['body' => $request->body]);

        return redirect(route('restaurants.detail', $comment->restaurant_id) . '#comment-' . $comment->id)
            ->with('success', 'Komentar berhasil diperbarui!');
    }

    /** DELETE /restoran/comments/{comment} */
    public function destroy(RestaurantComment $comment)
    {
        $isOwner = $comment->user_id === Auth::id();
        $isAdmin = in_array(Auth::user()->role, ['admin', 'superadmin']);

        abort_if(!$isOwner && !$isAdmin, 403, 'Unauthorized.');

        $comment->delete();

        return redirect(route('restaurants.detail', $comment->restaurant_id) . '#comments')
            ->with('success', 'Komentar berhasil dihapus!');
    }
}