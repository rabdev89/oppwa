<?php

namespace Rabcreatives\Oppwa\Components\Transaction\Transformations;

use Rabcreatives\Oppwa\Components\Transaction\Transaction;

trait TransactionTransformable
{
    /**
     * Transform the transaction
     *
     * @param Transaction $transaction
     * @return Transaction
     */
    protected function transactionTransform(Transaction $transaction)
    {
        $transact = new Transaction;
        $transact->id = (int) $transaction->transactionid;
        $transact->transaction_type = $transaction->transaction_type;
        $transact->credentialid = $transaction->credentialid;
        $transact->datetime_request = $transaction->datetime_request;
        $transact->request = json_decode($transaction->request);
        $transact->datetime_response = $transaction->datetime_response;
        $transact->response_status = $transaction->response_status;
        $transact->response = json_decode($transaction->response);

        return $transact;
    }
}
