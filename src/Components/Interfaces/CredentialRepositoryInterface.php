<?php

namespace Rabcreatives\Oppwa\Components\Interfaces;

use Rabcreatives\Oppwa\Components\Base\Repositories\BaseRepositoryInterface;
use Rabcreatives\Oppwa\Components\Credential\Credential;
use Illuminate\Support\Collection;

interface CredentialRepositoryInterface extends BaseRepositoryInterface
{
    public function listCredential(string $order = 'id', string $sort = 'desc'): Collection;

    public function createCredential(array $params) : Credential;

    public function findCredentialById(int $id) : Credential;

    public function updateCredential(array $params): bool;

    public function removeCredential() : bool;
}
