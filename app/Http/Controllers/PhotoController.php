<?php

namespace App\Http\Controllers;

use App\Helpers\SiHelper;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    /**
     * Delete photo
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function deleteAction($id)
    {
        $photo = Photo::with('ad')
            ->find($id);

        if (!$photo) {
            return redirect()->route('ad.list')->withErrors('Photo not found');
        }

        if (!Auth::id() || Auth::id() != $photo->ad->user_id) {
            return redirect()->route('ad.list')->withErrors('Only an ad owner can delete photo');
        }

        $adId = $photo->ad->id;
        Storage::disk(Photo::DISK_STORAGE_PHOTO)->delete($photo->path);

        try {
            $photo->delete();
        } catch (\Exception $e) {
            return redirect()->route('ad.update', $adId)->withErrors('An error has occurred');
        }

        return redirect()->route('ad.update', $adId)->with('success', 'Successfully saved');
    }
}
