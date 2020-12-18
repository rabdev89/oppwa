<?php

namespace Rabcreatives\Oppwa\Components\Interfaces;

use Rabcreatives\Oppwa\Components\Base\Repositories\BaseRepositoryInterface;
use Rabcreatives\Oppwa\Components\History\History;
use Illuminate\Support\Collection;

interface HistoryRepositoryInterface extends BaseRepositoryInterface
{
    public function listHistory(string $order = 'id', string $sort = 'desc'): Collection;

    public function createHistory(array $params) : History;

    public function findHistoryById(int $id) : History;

    public function updateHistory(array $params): bool;

    public function listIntegration() : Collection;

    public function deleteHistory() : bool;
}
