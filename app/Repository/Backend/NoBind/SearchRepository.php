<?php


namespace App\Repository\Backend\NoBind;


use App\Service\Backend\DateFilmService;

class SearchRepository
{
    protected $filmService;

    public function __construct(DateFilmService $filmService)
    {
        $this->filmService = $filmService;
    }

    public function search($data)
    {
        if (isset($data['date'])) {
            $data = $this->date($data['date']);
        }
        return $data;
    }

    public function date($date)
    {
        $idArr = [];
        $dateArr = explode(' - ', $date);
        $data = $this->filmService->searchDate($dateArr[0], $dateArr[1]);
        foreach ($data as $index => $item) {
            array_push($idArr,$item->id);
        }
        return array_unique($idArr);
    }

    public function genre($genre = [])
    {

    }
}
