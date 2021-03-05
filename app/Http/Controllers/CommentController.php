<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CommentController extends Controller
{
    /**
     * New comment
     *
     * @param CommentRequest $req
     * @return RedirectResponse
     */
    public function createAction(CommentRequest $req)
    {
        $user = Auth::user();

        if (!$user || !$user->id) {
            return redirect()->route('ad.details', $req->ad_id)->withErrors('Please login to complete this action');
        }

        $ad = Comment::create([
            'comment' => $req->comment,
            'ad_id' => $req->ad_id,
            'user_id' => $user->id,
        ]);
        $ad->save();

        return redirect()->route('ad.details', $req->ad_id)->with('success', 'Comment successfully added');
    }

    /**
     * Delete comment
     * @param $id
     * @return Application|Factory|RedirectResponse|View
     */
    public function deleteAction($id)
    {
        $comment = Comment::with('ad')
            ->find($id);

        $adId = $comment->ad->id;
        if (Auth::id() != $comment->ad->user_id) {
            return redirect()->route('ad.details', $adId)->withErrors('Only an ad owner can delete comment');
        }

        try {
            $comment->delete();
        } catch (\Exception $e) {
            return redirect()->route('ad.details', $adId)->withErrors('An error has occurred');
        }

        return redirect()->route('ad.details', $adId)->with('success', 'Successfully deleted');
    }
}
