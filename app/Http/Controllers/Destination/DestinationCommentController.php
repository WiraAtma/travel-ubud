<?php

namespace App\Http\Controllers\Destination;

use Illuminate\Routing\Controller as BaseController;
use App\Models\Destination\Destination;
use App\Models\Destination\DestinationComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DestinationCommentController extends BaseController
{
    /** POST /destinasi/{destination}/comments */
    public function store(Request $request, Destination $destination)
    {
        $request->validate([
            'body'      => 'required|string|max:2000',
            'parent_id' => 'nullable|integer|exists:destination_comments,id',
        ]);

        if ($request->parent_id) {
            $parent = DestinationComment::findOrFail($request->parent_id);
            abort_if($parent->destination_id !== $destination->id, 422, 'Invalid parent comment.');
        }

        DestinationComment::create([
            'destination_id' => $destination->id,
            'user_id'        => Auth::id(),
            'parent_id'      => $request->parent_id,
            'body'           => $request->body,
        ]);

        return redirect()
            ->route('destinations.detail', $destination->id)
            ->with('success', 'Komentar berhasil ditambahkan!');
    }

    /** PUT /destinasi/comments/{comment} */
    public function update(Request $request, DestinationComment $comment)
    {
        abort_if($comment->user_id !== Auth::id(), 403, 'Unauthorized.');

        $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        $comment->update(['body' => $request->body]);

        return redirect()
            ->route('destinations.detail', $comment->destination_id)
            ->with('success', 'Komentar berhasil diperbarui!');
    }

    /** DELETE /destinasi/comments/{comment} */
    public function destroy(DestinationComment $comment)
    {
        $isOwner = $comment->user_id === Auth::id();
        $isAdmin = in_array(Auth::user()->role, ['admin', 'superadmin']);

        abort_if(!$isOwner && !$isAdmin, 403, 'Unauthorized.');

        $comment->delete();

        return redirect()
            ->route('destinations.detail', $comment->destination_id)
            ->with('success', 'Komentar berhasil dihapus!');
    }
}