<?php

namespace Rabcreatives\Oppwa\Components\Interfaces;

use Rabcreatives\Oppwa\Components\Base\Repositories\BaseRepositoryInterface;
use Rabcreatives\Oppwa\Components\Transaction\Transaction;
use Illuminate\Support\Collection;

interface TransactionRepositoryInterface extends BaseRepositoryInterface
{
    public function listTransaction(string $order = 'id', string $sort = 'desc'): Collection;

    public function createTransaction(array $params) : Transaction;

    public function findTransactionById(int $id) : Transaction;

    public function updateTransaction(array $params): bool;

    public function deleteTransaction() : bool;
}
