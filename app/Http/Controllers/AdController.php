<?php

namespace App\Http\Controllers;

use App\Helpers\SiHelper;
use App\Http\Requests\AdRequest;
use App\Models\Ad;
use App\Models\Comment;
use App\Models\Photo;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdController extends Controller
{

    private const DEFAULT_PER_PAGE = 12;

    private const MAX_PER_PAGE = 50;

    private const DEFAULT_PAGE = 1;

    /**
     * New ad
     *
     * @param Request $req
     * @return RedirectResponse
     */
    public function createNewInstance(AdRequest $req)
    {
        // Check user auth
        if (!SiHelper::isUserLogged()) {
            return redirect()->route('ad.list')->withErrors('Please login to complete this action');
        }

        // Save ad data
        $ad = Ad::create([
            'title' => $req->title,
            'description' => $req->description,
            'user_id' => Auth::id(),
        ]);
        $ad->save();

        // Save ad photos
        $photos = $req->file('photos', []);
        if (!Photo::createPhotosFromRequest($photos, $ad->id)) {
            return redirect()->route('ad.list')->withErrors('Ad created, but an error occurred while saving photos');
        }

        return redirect()->route('ad.list')->with('success', 'Successfully saved');
    }

    /**
     * Show update form
     * @param $id
     * @return Application|Factory|RedirectResponse|View
     */
    public function update($id)
    {
        // Check user auth
        if (!SiHelper::isUserLogged()) {
            return redirect()->route('ad.list')->withErrors('Please login to complete this action');
        }

        /** @var Ad $ad */
        $ad = Ad::with('photos')
            ->with('user')
            ->find((int)$id);

        if (!$ad) {
            return redirect()->route('ad.list')->withErrors('Ad not found');
        }

        if (!$ad->checkOwnerIsCurrentUser()) {
            return redirect()->route('ad.list')->withErrors('Only an ad owner can update an ad');
        }

        return view('ads.update', [
            'adData' => $ad->toArray(),
        ]);
    }

    /**
     * Update ad
     * @param AdRequest $req
     * @return Application|Factory|RedirectResponse|View
     */
    public function updateAction(AdRequest $req)
    {
        if (!$req->id) {
            return redirect()->route('ad.list')->withErrors('Ad not found');
        }
        /** @var Ad $ad */
        $ad = Ad::find((int)$req->id);

        if (!$ad) {
            return redirect()->route('ad.list')->withErrors('Ad not found');
        }

        if (!$ad->checkOwnerIsCurrentUser()) {
            return redirect()->route('ad.list')->withErrors('Only an ad owner can update an ad');
        }

        // Save ad data
        $ad->title = $req->title;
        $ad->description = $req->description;
        $ad->save();

        // Save ad photos
        $photos = $req->file('photos', []);
        if (!Photo::createPhotosFromRequest($photos, $ad->id)) {
            return redirect()->route('ad.list')->withErrors('Ad created, but an error occurred while saving photos');
        }

        return redirect()->route('ad.list')->with('success', 'Changes successfully saved');
    }

    /**
     * List of ads
     * @param Request $req
     * @return Application|Factory|View
     */
    public function showAds(Request $req)
    {
        $adsCount = Ad::all()->count();

        $pagination = SiHelper::getPaginationFromRequest(
            $req,
            [
                'defaultPage' => self::DEFAULT_PAGE,
                'defaultPerPage' => self::DEFAULT_PER_PAGE,
                'itemsCount' => $adsCount,
                'maxPerPage' => self::MAX_PER_PAGE,
            ]
        );
        $pagination['maxPage'] = SiHelper::getRoundUpInt($adsCount / $pagination['perPage']);

        $adsData = Ad::with('user')
            ->with('photos')
            ->withCount('comments')
            ->offset($pagination['perPage'] * ($pagination['page'] - 1))
            ->limit($pagination['perPage'])
            ->get()
            ->map(function ($ad) {
                $user = $ad->getRelation('user');
                $photos = $ad->getRelation('photos')
                    ->map(function ($photo) {
                        return $photo->toArray();
                    });
                return [
                    'id' => $ad->id,
                    'title' => $ad->title,
                    'description' => $ad->description,
                    'createdAt' => $ad->created_at->format('Y-m-d h:i'),
                    'username' => $user->name,
                    'userMail' => $user->email,
                    'commentsCount' => $ad->comments_count,
                    'photos' => $photos
                ];
            });

        return view('ads.list', [
            'adsData' => $adsData,
            'pagination' => $pagination,
        ]);
    }

    /**
     * Details of ad
     * @param $id
     * @return Application|Factory|RedirectResponse|View
     */
    public function adDetails($id)
    {
        $ad = Ad::with('photos')->find((int)$id);

        if (!$ad) {
            return redirect()->route('ad.list')->withErrors('Ad not found');
        }

        $adData = [
            'id' => $ad->id,
            'title' => $ad->title,
            'description' => $ad->description,
            'createdAt' => $ad->created_at->format('Y-m-d h:i'),
            'username' => $ad->user->name,
            'userMail' => $ad->user->email,
            'photos' => [],
        ];

        $adData['photos'] = $ad->getRelation('photos')
            ->map(function ($photo) {
                return $photo->toArray();
            });

        $comments = Comment::with('user')
            ->where('ad_id', $ad->id)
            ->get()
            ->map(function ($comment) {
                $user = $comment->getRelation('user');
                return [
                    'id' => $comment->id,
                    'comment' => $comment->comment,
                    'createdAt' => $comment->created_at->format('Y-m-d h:i'),
                    'username' => $user->name,
                    'userMail' => $user->email,
                    'isDeletable' => $user->id == Auth::id(),
                ];
            });

        return view('ads.details', [
            'isOwner' => (int)$ad->user->id == Auth::id(),
            'adData' => $adData,
            'comments' => $comments,
        ]);
    }
}
