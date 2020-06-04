<?php


namespace App\Repository\Backend;


use App\Models\Checked;
use App\Repository\Backend\Interfaces\DateFilmRepositoryInterfaces;
use App\Service\Backend\CheckedService;
use App\Service\Backend\DateFilmService;

class DateFilmRepository implements DateFilmRepositoryInterfaces
{
    /**
     * @var DateFilmService
     */
    protected $service;
    /**
     * @var CheckedService
     */
    protected $checked;

    /**
     * DateFilmRepository constructor.
     * @param DateFilmService $service
     * @param CheckedService $checked
     */
    public function __construct(DateFilmService $service, CheckedService $checked)
    {
        $this->service = $service;
        $this->checked = $checked;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->service->find($id);
    }

    /**
     * @param $date_id
     * @return array|mixed
     */
    public function getFilmData($date_id)
    {
        $checked_lines = [];
        $date = $this->service->find($date_id);
        $checked = $this->checked->lists($date->film->id, $date_id);
        $newArr = true;
        $last_id = 0;
        foreach ($checked as $item) {
            if ($item->count_line->line->id !== $last_id && !isset($checked_lines[$item->count_line->line->id])) {
                $checked_lines[$item->count_line->line->id] = [];
                $newArr = true;
            }
            if ($newArr) {
                $newArr = false;
                $last_id = $item->count_line->line->id;
            }
            array_push($checked_lines[$item->count_line->line->id], $item->count_line->id);
        }
        return $checked_lines;
    }
}
