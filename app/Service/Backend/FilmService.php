<?php


namespace App\Service\Backend;


use App\Models\Film;
use Illuminate\Support\Facades\Auth;

class FilmService extends Film
{
    protected $table = 'films';

    /**
     * @return FilmService[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return $this->all();
    }

    public function getAuth()
    {
        return parent::where('user_id', Auth::id())->get();
    }

    /**
     * @param $id
     * @param $user_id
     * @return mixed
     */
    public function firstOrNew($id, $user_id)
    {
        return parent::firstOrNew(['id' => $id, 'user_id' => $user_id]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return parent::find($id);
    }
}
