<?php

namespace App\Services;

use App\Models\Favorite;
use App\Repositories\FavoriteRepository;

class FavoriteService
{
    private $favoriteRepository;
    /**
     * Class constructor.
     */
    public function __construct(FavoriteRepository $favoriteRepository)
    {
        $this->favoriteRepository = $favoriteRepository;
    }

    public function toogle($user_id, $product_id)
    {
        $isFavorite = $this->favoriteRepository->isFavorite($user_id, $product_id);

        if ($isFavorite) {
            $this->favoriteRepository->removeFromFavorites($user_id, $product_id);
            return [
                "status_favorite" => false,
                "message" => "Success remove to favorite!"
            ];
        } else {
            $this->favoriteRepository->addToFavorites($user_id, $product_id);
            return [
                "status_favorite" => true,
                "message" => "Success add to favorite!"
            ];
        }
    }
}
