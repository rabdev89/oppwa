<?php

namespace Rabcreatives\Oppwa\Components\Interfaces;

use Rabcreatives\Oppwa\Components\Base\Repositories\BaseRepositoryInterface;
use Rabcreatives\Oppwa\Components\Invoice\Invoice;
use Illuminate\Support\Collection;

interface InvoiceRepositoryInterface extends BaseRepositoryInterface
{
    public function listInvoice(string $order = 'id', string $sort = 'desc'): Collection;

    public function createInvoice(array $params) : Invoice;

    public function findInvoiceById(int $id) : Invoice;

    public function updateInvoice(array $params): bool;

    public function listIntegration() : Collection;

    public function deleteInvoice() : bool;
}
