<?php

namespace Rabcreatives\Oppwa\Components\Interfaces;

use Rabcreatives\Oppwa\Components\Base\Repositories\BaseRepositoryInterface;
use Rabcreatives\Oppwa\Components\Configuration\Configuration;
use Illuminate\Support\Collection;

interface ConfigurationRepositoryInterface extends BaseRepositoryInterface
{
    public function listConfiguration(string $order = 'id', string $sort = 'desc'): Collection;

    public function createConfiguration(array $params) : Collection;

    public function findConfigurationById(int $id) : Collection;

    public function updateConfiguration(array $params): bool;

    public function listIntegration() : Collection;

    public function deleteConfiguration() : bool;
}
