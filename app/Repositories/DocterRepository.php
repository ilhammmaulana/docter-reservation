<?php

namespace App\Repositories;

use App\Models\CategoryDocter;
use App\Models\Docter;
use App\Models\Reservation;
use App\Models\SavedDocter;
use App\Models\Subdistrict;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DocterRepository
{
    public static function countDocter()
    {
        return Docter::count();
    }
    public static function searchDocter($q, $user_id)
    {
        $docters = Docter::with(['images', 'category', 'subdistrict'])
            ->leftJoin('saved_docters', 'docters.id', '=', 'saved_docters.docter_id')
            ->select('docters.*', DB::raw("IF(saved_docters.created_by = '$user_id', 1, 0) as save_by_you"))
            ->where('docters.name', 'like', "%" . $q . "%")->get();
        return $docters;
    }

    public function all($paginate = false, $totalData = 10)
    {
        if ($paginate) {
            $docters = Docter::with(['images', 'category', 'subdistrict'])->latest()->paginate($totalData);
        } else {
            $docters = Docter::with(['images', 'category', 'subdistrict'])->latest()->get();
        }
        return $docters;
    }
    public function getDocters($user_id)
    {
        $docters = Docter::with(['images', 'category', 'subdistrict'])
            ->leftJoin('saved_docters', function ($join) use ($user_id) {
                $join->on('docters.id', '=', 'saved_docters.docter_id')
                    ->where('saved_docters.created_by', $user_id);
            })
            ->select('docters.*', DB::raw('IF(saved_docters.docter_id IS NOT NULL, 1, 0) as save_by_you'))
            ->get();
        return $docters;
    }
    public function getDocterById($id, $user_id)
    {
        $docters = Docter::with(['images', 'category', 'subdistrict'])
            ->leftJoin('saved_docters', function ($join) use ($user_id) {
                $join->on('docters.id', '=', 'saved_docters.docter_id')
                    ->where('saved_docters.created_by', $user_id);
            })
            ->select('docters.*', DB::raw("IF(saved_docters.created_by = '$user_id', 1, 0) as save_by_you"))
            ->where('id', $id)
            ->firstOrFail();
        return $docters;
    }

    public function getDocterBySubdistrictId($subdistrictId, $user_id)
    {
        Subdistrict::findOrFail($subdistrictId);
        $docters = Docter::with(['images', 'category', 'subdistrict'])->where('subdistrict_id', $subdistrictId)
            ->leftJoin('saved_docters', function ($join) use ($user_id) {
                $join->on('docters.id', '=', 'saved_docters.docter_id')
                    ->where('saved_docters.created_by', $user_id);
            })->select('docters.*', DB::raw("IF(saved_docters.created_by = '$user_id', 1, 0) as save_by_you"))
            ->get();
        return $docters;
    }
    public function getDocterByCategoryId($categoryId, $user_id)
    {
        CategoryDocter::findOrFail($categoryId);
        $docters = Docter::with(['images', 'category', 'subdistrict'])
            ->leftJoin('saved_docters', function ($join) use ($user_id) {
                $join->on('docters.id', '=', 'saved_docters.docter_id')
                    ->where('saved_docters.created_by', $user_id);
            })->select('docters.*', DB::raw("IF(saved_docters.created_by = '$user_id', 1, 0) as save_by_you"))
            ->where('category_docter_id', $categoryId)
            ->get();
        return $docters;
    }
    public function savedDocter($created_by, $idDocter)
    {
        SavedDocter::create([
            'created_by' => $created_by,
            'docter_id' => $idDocter
        ]);
    }
    public function removeDocterFromSavedDocter($created_by, $idDocter)
    {
        SavedDocter::where('created_by', $created_by)->where('docter_id', $idDocter)->delete();
    }
    public function isSaved($created_by, $idDocter)
    {
        $save_docter = SavedDocter::where('created_by', $created_by)->where('docter_id', $idDocter)->first();
        return $save_docter !== null;
    }
    public function getSavedDocter($user_id)
    {
        $docters = Docter::with(['images', 'category', 'subdistrict'])
            ->leftJoin('saved_docters', 'docters.id', '=', 'saved_docters.docter_id')
            ->where('saved_docters.created_by', $user_id)
            ->select('docters.*', DB::raw('IF(saved_docters.docter_id IS NOT NULL, 1, 0) as save_by_you'))
            ->get();

        return $docters;
    }
    public function getDocterHistory($user_id)
    {
        $orderedDoctors = Reservation::where('created_by', $user_id)->latest()->take(3)->pluck('docter_id');
        $docters = Docter::with(['images', 'category', 'subdistrict'])
        ->leftJoin('saved_docters', function ($join) use ($user_id) {
            $join->on('docters.id', '=', 'saved_docters.docter_id')
                ->where('saved_docters.created_by', $user_id);
        })
        ->select('docters.*', DB::raw('IF(saved_docters.docter_id IS NOT NULL, 1, 0) as save_by_you'))
        ->whereIn('id',$orderedDoctors)->get();
    return $docters;
        
    }
    public function filterDocter($category_id, $subdistrict_id, $user_id)
    {
        $docters = Docter::with(['images', 'category', 'subdistrict'])->where('category_id', $category_id)->where('subdistrict_id', $subdistrict_id)
            ->leftJoin('saved_docters', function ($join) use ($user_id) {
                $join->on('docters.id', '=', 'saved_docters.docter_id')
                    ->where('saved_docters.created_by', $user_id);
            })->select('docters.*', DB::raw("IF(saved_docters.created_by = '$user_id', 1, 0) as save_by_you"))
            ->get();
        return $docters;
    }
}
