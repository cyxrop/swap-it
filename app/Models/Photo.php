<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Photo extends Model
{
    public const STORAGE_PATH_PHOTO = 'photos/';

    public const DISK_STORAGE_PHOTO = 'public';

    /**
     *  Prefix of public storage path - example: localhost:8000/storage/photos/photoname.jpg
     */
    public const PREFIX_URL_STORAGE = 'storage/';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'path', 'ad_id'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the ad related with comment.
     */
    public function ad(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Ad');
    }

    public function getSourceUrl()
    {
        return Photo::PREFIX_URL_STORAGE . $this->path;
    }

    /**
     * Override toArray method
     * @return array
     */
    public function toArray()
    {
        $arr = parent::toArray();
        $arr['src'] = $this->getSourceUrl();
        return $arr;
    }

    /**
     * @param $photos
     * @param $adId
     * @return bool|\Illuminate\Http\RedirectResponse
     */
    static public function createPhotosFromRequest($photos, $adId)
    {
        foreach ($photos as $photo) {
            try {
                $path = Storage::disk(Photo::DISK_STORAGE_PHOTO)
                    ->put(Photo::STORAGE_PATH_PHOTO . $adId, $photo);
                Photo::create([
                    'path' => $path,
                    'ad_id' => $adId,
                ]);
            } catch (\Exception $e) {
                return false;
            }
        }
        return true;
    }
}
