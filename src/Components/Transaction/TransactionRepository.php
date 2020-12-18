<?php

namespace Rabcreatives\Oppwa\Components\Transaction;

use Rabcreatives\Oppwa\Components\Base\Repositories\BaseRepository;
use Rabcreatives\Oppwa\Components\Transaction\Exceptions\TransactionCreateErrorException;
use Rabcreatives\Oppwa\Components\Transaction\Exceptions\TransactionUpdateErrorException;
use Rabcreatives\Oppwa\Components\Transaction\Exceptions\TransactionNotFoundException;
use Rabcreatives\Oppwa\Components\Transaction\Transformations\TransactionTransformable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Rabcreatives\Oppwa\Components\Interfaces\TransactionRepositoryInterface;

class TransactionRepository extends BaseRepository  implements TransactionRepositoryInterface
{
    use TransactionTransformable;

    /**
     * TransactionRepository constructor.
     * @param Transaction $transaction
     */
    public function __construct(Transaction $transaction)
    {
        parent::__construct($transaction);
        $this->model = $transaction;
    }

    /**
     * List all the expenses
     *
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return Collection
     */
    public function listTransaction(string $order = 'id', string $sort = 'desc', array $columns = ['*']) : Collection
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * Create the Transaction
     *
     * @param array $data
     *
     * @return Transaction
     * @throws TransactionCreateErrorException
     */
    public function createTransaction(array $data) : Transaction
    {
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new TransactionCreateErrorException($e);
        }
    }

    /**
     * Update the Transaction
     *
     * @param array $data
     *
     * @return bool
     * @throws TransactionUpdateErrorException
     */
    public function updateTransaction(array $data) : bool
    {
        $filtered = collect($data)->all();

        try {
            return $this->model->where('id', $this->model->id)->update($filtered);
        } catch (QueryException $e) {
            throw new TransactionUpdateErrorException($e);
        }
    }

    /**
     * Find the Transaction by ID
     *
     * @param int $id
     *
     * @return Transaction
     * @throws TransactionNotFoundException
     */
    public function findTransactionById(int $id) : Transaction
    {
        try {
            return $this->transactionTransform($this->findOneOrFail($id));
        } catch (ModelNotFoundException $e) {
            throw new TransactionNotFoundException($e);
        }
    }


    /**
     * Find the Transaction by ID
     *
     * @param int $id
     *
     * @return Transaction
     * @throws TransactionNotFoundException
     */
    public function findTransactionByResponseId(string $responseId) : Transaction
    {
        try {
            return $this->transactionTransform($this->findOneBy(['response_id' => $responseId, 'transaction_type' => 'checkout']));
        } catch (ModelNotFoundException $e) {
            throw new TransactionNotFoundException($e);
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function removeTransaction() : bool
    {
        return $this->model->where('id', $this->model->id)->delete();
    }

    /**
     * Delete the expenses
     *
     * @param Configuration $configuration
     *
     * @return bool
     * @throws \Exception
     * @deprecated
     * @use removeConfiguration
     */
    public function deleteTransaction() : bool
    {
        return $this->delete();
    }

    /**
     * @param string $text
     * @return mixed
     */
    public function searchTransaction(string $text) : Collection
    {
        if (!empty($text)) {
            return $this->model->searchTransaction($text);
        } else {
            return $this->listTransaction();
        }
    }


}
