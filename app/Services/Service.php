<?php


namespace App\Services;


class Service
{
    protected $limit;
    protected $offset;

    public function __construct()
    {
        $this->limit = config('main.limit');
        $this->offset = config('main.offset');
    }

    protected function limit($query, $data)
    {
        if (isset($data['offset'])) {
            $query = $query->offset($data['offset']);
        } else {
            $query = $query->offset($this->offset);
        }

        if (isset($data['limit'])) {
            $query = $query->limit($data['limit']);
        } else {
            $query = $query->limit($this->limit);
        }

        return $query;
    }
}
