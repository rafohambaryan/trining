<?php


namespace App\Service\Backend;


use App\Helpers\Hash;
use App\Models\Checked;

class CheckedService extends Checked
{
    /**
     * @var string
     */
    protected $table = 'checkeds';

    /**
     * @param $film_id
     * @param $date_film_id
     * @param $count_line_id
     * @return bool
     */
    public function test($film_id, $date_film_id, $count_line_id): bool
    {
        return !parent::where('film_id', $film_id)->where('date_film_id', $date_film_id)->where('count_line_id', $count_line_id)->first();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function checked($data)
    {
        $data['card'] = Hash::unique($this, 'card', 6);
        return parent::create($data);
    }

    /**
     * @param $film_id
     * @param $date_id
     * @return mixed
     */
    public function lists($film_id, $date_id)
    {
        return parent::where('film_id', $film_id)->where('date_film_id', $date_id)->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function getChecked($data)
    {
        return parent::where('count_line_id', $data['count_line_id'])->where('date_film_id', $data['date_film_id'])->first();
    }

    /**
     * @param $code
     * @return mixed
     */
    public function getCode($code)
    {
        return parent::where('card', $code)->first();
    }
}
