<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Handbook extends Model
{
    protected $table;
    protected $fillable = [
        'title',
        'order',
        'with_comment',
        'period',
        'period_type',
        'color',
        'white_text',
        'is_last',
        'city_id',
        'unsubscribe_period',
    ];

    /**
     * @param string $table
     * @param $request
     * @return array
     */
    public function getHandbook(string $table, $request = []) :array
    {
        $this->table = $table;

        $limit   = !empty($request->limit) ? (int)$request->limit : 10;
        $sort    = !empty($request->sort) ? $request->sort : 'order';
        $orderBy = !empty($request->orderBy) ? 'desc' : 'asc';

        $query = self::select();

        if(! empty($request->all) && $request->all) {
            return $query->orderBy('order')->get()->toArray();
        }
        if(! empty($request->id)) {
            return $query->where('id', $request->id)->first()->toArray();
        }
        if(! empty($request->get_last)) {
            return ['last_stage' => $query->where('is_last', true)->first()];
        }

        if(! empty($request->city_id)) $query->where('city_id', $request->city_id);
        if(! empty($request->filterSearch)) $query->where('title', 'ilike', '%' . $request->filterSearch . '%');

        $list = $query->orderBy($sort, $orderBy)->paginate($limit);

        return [
            'data'  => $list->items() ?? [],
            'count' => $list->total(),
        ];
    }

    /**
     * @param string $table
     * @param int $id
     * @return array
     */
    public function getHandbookItem(string $table, int $id) :array
    {
        $this->table = $table;

        $response = [
            'data'  => self::findOrFail($id),
        ];

        return $response;
    }

    /**
     * @param string $table
     * @param Request $request
     * @return array
     */
    public function saveHandbookItem(string $table, Request $request) :array
    {
        $this->table = $table;

        $response = [
            'message' => 'Запис збережено',
        ];

        if(! empty($request->id)){
            $query = self::find($request->id);
            $query->update($request['fields']);
        } else {
            $response['data'] = self::create($request['fields']);
            $response['message'] = 'Запис створено';
        }

        return $response;
    }

    /**
     * @param string $table
     * @param int $id
     * @return array
     */
    public function removeHandbookItem(string $table, int $id) :array
    {
        $this->table = $table;

        $response = [
            'message' => 'Запис видалено',
        ];

        $query = self::find($id);

        if ( ! is_null($query)) {
            $query->delete();
        } else {
            $response = [
                'code' => 404,
                'message' => 'Запис не знайдений'
            ];
        }

        return $response;
    }
}
