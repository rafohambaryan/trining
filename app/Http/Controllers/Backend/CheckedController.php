<?php

namespace App\Http\Controllers\Backend;

use App\Events\CheckedEvent;
use App\Events\FilmEvent;
use App\Repository\Backend\Interfaces\CheckedRepositoryInterfaces;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;

class CheckedController extends Controller
{
    /**
     * @var CheckedRepositoryInterfaces
     */
    protected $interfaces;

    /**
     * CheckedController constructor.
     * @param CheckedRepositoryInterfaces $interfaces
     */
    public function __construct(CheckedRepositoryInterfaces $interfaces)
    {
        $this->interfaces = $interfaces;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getChecked(Request $request)
    {
        $list = Event::dispatch(new CheckedEvent('getOneChecked', $request->all()), true, true);
        $data['success'] = false;
        if ($list) {
            $data = $this->getToms($list);
        }
        return response()->json($data);
    }

    /**
     * @param $card
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCard($card)
    {
        $list = $this->interfaces->getCode($card);
        $data['success'] = false;
        if ($list) {
            $data = $this->getToms($list);
        }
        return response()->json($data);
    }

    /**
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteCard($code)
    {
        $data['success'] = false;
        $list = $this->interfaces->getCode($code);
        if ($list) {
            $list->delete();
            $data['success'] = true;
        }
        return response()->json($data);
    }

    /**
     * @param $checked
     * @return mixed
     */
    private function getToms($checked)
    {
        $data['success'] = true;
        $data['film'] = $checked->film->name;
        $data['date']['start'] = $checked->date->start_date;
        $data['date']['end'] = $checked->date->end_date;
        $data['card'] = $checked->card;
        $data['line'] = $checked->count_line->line->name . ' N ' . $checked->count_line->line->order;
        $data['chair'] = $checked->count_line->order;
        return $data;
    }
}
