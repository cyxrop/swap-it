<?php


namespace App\Helpers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiHelper
{
    /**
     * @param Request $req
     * @param array $params
     * @return array
     */
    static public function getPaginationFromRequest($req, $params = []): array
    {
        $curPage = intval($req->page);
        $perPage = intval($req->perPage);

        if (!$curPage && isset($params['defaultPage'])) {
            $curPage = $params['defaultPage'];
        }

        if (!$perPage && isset($params['defaultPerPage'])) {
            $perPage = $params['defaultPerPage'];
        }

        if (isset($params['maxPerPage']) && $perPage > $params['maxPerPage']) {
            $perPage = $params['maxPerPage'];
        }

        if (isset($params['itemsCount'])) {
            $maxPage = self::getRoundUpInt($params['itemsCount'] / $perPage);
            $curPage = $curPage < $maxPage ? $curPage : $maxPage;
        }

        return [
            'page' => $curPage,
            'perPage' => $perPage,
        ];
    }

    /**
     * @param $value
     * @return int
     */
    static public function getRoundUpInt($value)
    {
        return intval(ceil($value));
    }

    static public function isUserLogged()
    {
        return Auth::check();
    }
}
