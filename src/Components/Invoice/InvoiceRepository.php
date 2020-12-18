<?php

namespace Rabcreatives\Oppwa\Components\Invoice;

use Rabcreatives\Oppwa\Components\Base\Repositories\BaseRepository;
use Rabcreatives\Oppwa\Components\Invoice\Exceptions\InvoiceCreateErrorException;
use Rabcreatives\Oppwa\Components\Invoice\Exceptions\InvoiceUpdateErrorException;
use Rabcreatives\Oppwa\Components\Invoice\Exceptions\InvoiceNotFoundException;
//use Rabcreatives\Oppwa\Components\Invoice\Transformations\InvoiceTransformable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Rabcreatives\Oppwa\Components\Interfaces\InvoiceRepositoryInterface;

class InvoiceRepository extends BaseRepository  implements InvoiceRepositoryInterface
{
    //use InvoiceTransformable;

    /**
     * InvoiceRepository constructor.
     * @param Invoice $invoice
     */
    public function __construct(Invoice $invoice)
    {
        parent::__construct($invoice);
        $this->model = $invoice;
    }

    /**
     * List all the expenses
     *
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return Collection
     */
    public function listInvoice(string $order = 'id', string $sort = 'desc', array $columns = ['*']) : Collection
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * Create the Invoice
     *
     * @param array $data
     *
     * @return Invoice
     * @throws InvoiceCreateErrorException
     */
    public function createInvoice(array $data) : Invoice
    {
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new InvoiceCreateErrorException($e);
        }
    }

    /**
     * Update the Invoice
     *
     * @param array $data
     *
     * @return bool
     * @throws InvoiceUpdateErrorException
     */
    public function updateInvoice(array $data) : bool
    {
        $filtered = collect($data)->all();

        try {
            return $this->model->where('id', $this->model->id)->update($filtered);
        } catch (QueryException $e) {
            throw new InvoiceUpdateErrorException($e);
        }
    }

    /**
     * Find the Invoice by ID
     *
     * @param int $id
     *
     * @return Invoice
     * @throws InvoiceNotFoundException
     */
    public function findInvoiceById(int $id) : Invoice
    {
        try {
            return $this->transformSimple($this->findOneOrFail($id));
        } catch (ModelNotFoundException $e) {
            throw new InvoiceNotFoundException($e);
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function removeInvoice() : bool
    {
        return $this->model->where('id', $this->model->id)->delete();
    }


    /**
     * @param string $text
     * @return mixed
     */
    public function searchInvoice(string $text) : Collection
    {
        if (!empty($text)) {
            return $this->model->searchInvoice($text);
        } else {
            return $this->listInvoice();
        }
    }


}
