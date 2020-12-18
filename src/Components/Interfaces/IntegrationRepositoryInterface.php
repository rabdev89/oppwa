<?php

namespace Rabcreatives\Oppwa\Components\Interfaces;

use Rabcreatives\Oppwa\Components\Base\Repositories\BaseRepositoryInterface;
use Rabcreatives\Oppwa\Components\Integration\Integration;
use Illuminate\Support\Collection;

interface IntegrationRepositoryInterface extends BaseRepositoryInterface
{
    public function listIntegration(string $order = 'id', string $sort = 'desc'): Collection;

    public function createIntegration(array $params) : Integration;

    public function findIntegrationById(int $id) : Integration;

    public function updateIntegration(array $params): bool;

    public function deleteIntegration() : bool;
}
