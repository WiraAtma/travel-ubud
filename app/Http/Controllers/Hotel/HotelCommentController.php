<?php

namespace App\Http\Controllers\Hotel;

use Illuminate\Routing\Controller as BaseController;
use App\Models\Hotel\Hotel;
use App\Models\Hotel\HotelComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HotelCommentController extends BaseController
{
    /** POST /hotel/{hotel}/comments */
    public function store(Request $request, Hotel $hotel)
    {
        $request->validate([
            'body'      => 'required|string|max:2000',
            'parent_id' => 'nullable|integer|exists:hotel_comments,id',
        ]);

        if ($request->parent_id) {
            $parent = HotelComment::findOrFail($request->parent_id);
            abort_if($parent->hotel_id !== $hotel->id, 422, 'Invalid parent comment.');
        }

        HotelComment::create([
            'hotel_id'   => $hotel->id,
            'user_id'    => Auth::id(),
            'parent_id'  => $request->parent_id,
            'body'       => $request->body,
        ]);

        $anchor = $request->parent_id ? '#comment-' . $request->parent_id : '#comments';

        return redirect(route('hotels.detail', $hotel->id) . $anchor)
            ->with('success', 'Komentar berhasil ditambahkan!');
    }

    /** PUT /hotel/comments/{comment} */
    public function update(Request $request, HotelComment $comment)
    {
        abort_if($comment->user_id !== Auth::id(), 403, 'Unauthorized.');

        $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        $comment->update(['body' => $request->body]);

        return redirect(route('hotels.detail', $comment->hotel_id) . '#comment-' . $comment->id)
            ->with('success', 'Komentar berhasil diperbarui!');
    }

    /** DELETE /hotel/comments/{comment} */
    public function destroy(HotelComment $comment)
    {
        $isOwner = $comment->user_id === Auth::id();
        $isAdmin = in_array(Auth::user()->role, ['admin', 'superadmin']);

        abort_if(!$isOwner && !$isAdmin, 403, 'Unauthorized.');

        $comment->delete();

        return redirect(route('hotels.detail', $comment->hotel_id) . '#comments')
            ->with('success', 'Komentar berhasil dihapus!');
    }
}