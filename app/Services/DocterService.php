<?php

namespace App\Services;

use App\Repositories\DocterRepository;

class DocterService
{
    private $docterRepository;
    /**
     * Class constructor.
     */
    public function __construct(DocterRepository $docterRepository)
    {
        $this->docterRepository = $docterRepository;
    }
    public function all()
    {
    }

    public function toogleSaveDocter($created_by, $docter_id)
    {

        $isFavorite = $this->docterRepository->isSaved($created_by, $docter_id);
        if ($isFavorite) {
            $this->docterRepository->removeDocterFromSavedDocter($created_by, $docter_id);
            return [
                "status_favorite" => false,
                "message" => "Success remove to favorite!"
            ];
        } else {
            $this->docterRepository->savedDocter($created_by, $docter_id);
            return [
                "status_favorite" => true,
                "message" => "Success add to favorite!"
            ];
        }
    }
}
