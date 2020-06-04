<?php


namespace App\Repository\Backend;


use App\Repository\Backend\Interfaces\CheckedRepositoryInterfaces;
use App\Service\Backend\CheckedService;

class CheckedRepository implements CheckedRepositoryInterfaces
{
    /**
     * @var CheckedService
     */
    protected $service;

    /**
     * CheckedRepository constructor.
     * @param CheckedService $service
     */
    public function __construct(CheckedService $service)
    {
        $this->service = $service;
    }

    /**
     * @param $data
     * @return array
     */
    public function checked($data)
    {
        $success = $this->service->test($data['film_id'], $data['date_film_id'], $data['count_line_id']);
        $card = 'error';
        if ($success) {
            $card = $this->service->checked($data)->card;
        }
        return ['success' => $success, 'card' => $card];
    }

    /**
     * @param $data
     * @return mixed
     */
    public function getOneChecked($data)
    {
        return $this->service->getChecked($data);
    }

    /**
     * @param $code
     * @return mixed
     */
    public function getCode($code)
    {
        return $this->service->getCode($code);
    }
}
