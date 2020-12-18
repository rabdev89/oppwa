<?php

namespace Rabcreatives\Oppwa\Components\History;

use Rabcreatives\Oppwa\Components\Base\Repositories\BaseRepository;
use Rabcreatives\Oppwa\Components\History\Exceptions\HistoryCreateErrorException;
use Rabcreatives\Oppwa\Components\History\Exceptions\HistoryUpdateErrorException;
use Rabcreatives\Oppwa\Components\History\Exceptions\HistoryNotFoundException;
//use Rabcreatives\Oppwa\Components\History\Transformations\HistoryTransformable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Rabcreatives\Oppwa\Components\Interfaces\HistoryRepositoryInterface;

class HistoryRepository extends BaseRepository  implements HistoryRepositoryInterface
{
    //use HistoryTransformable;

    /**
     * HistoryRepository constructor.
     * @param History $history
     */
    public function __construct(History $history)
    {
        parent::__construct($history);
        $this->model = $history;
    }

    /**
     * List all the expenses
     *
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return Collection
     */
    public function listHistory(string $order = 'id', string $sort = 'desc', array $columns = ['*']) : Collection
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * Create the History
     *
     * @param array $data
     *
     * @return History
     * @throws HistoryCreateErrorException
     */
    public function createHistory(array $data) : History
    {
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new HistoryCreateErrorException($e);
        }
    }

    /**
     * Update the History
     *
     * @param array $data
     *
     * @return bool
     * @throws HistoryUpdateErrorException
     */
    public function updateHistory(array $data) : bool
    {
        $filtered = collect($data)->all();

        try {
            return $this->model->where('id', $this->model->id)->update($filtered);
        } catch (QueryException $e) {
            throw new HistoryUpdateErrorException($e);
        }
    }

    /**
     * Find the History by ID
     *
     * @param int $id
     *
     * @return History
     * @throws HistoryNotFoundException
     */
    public function findHistoryById(int $id) : History
    {
        try {
            return $this->transformSimple($this->findOneOrFail($id));
        } catch (ModelNotFoundException $e) {
            throw new HistoryNotFoundException($e);
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function removeHistory() : bool
    {
        return $this->model->where('id', $this->model->id)->delete();
    }


    /**
     * @param string $text
     * @return mixed
     */
    public function searchHistory(string $text) : Collection
    {
        if (!empty($text)) {
            return $this->model->searchHistory($text);
        } else {
            return $this->listHistory();
        }
    }


}
