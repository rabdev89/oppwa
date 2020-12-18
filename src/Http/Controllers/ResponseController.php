<?php

namespace Rabcreatives\Oppwa\Http\Controllers;
use Illuminate\Http\Request;
use Rabcreatives\Oppwa\Helpers\Url;
use Rabcreatives\Oppwa\Oppwa;
use Rabcreatives\Oppwa\Traits\CurrencyTraits;
use Rabcreatives\Oppwa\Http\Requests\ResponseRequest;
use Rabcreatives\Oppwa\Components\Interfaces\TransactionRepositoryInterface;
use Carbon\Carbon;

class ResponseController extends Controller
{
    use CurrencyTraits;
    /**
     * @var Url
     */
    private $url;

    private $oppwaClient;

    private $oppwa;


    /**
     * @var TransactionRepositoryInterface
     */
    private $transactionRepo;


    /**
     * ResponseController constructor.
     *
     * @param TransactionRepositoryInterface $transactionRepo
     *
     */
    public function __construct(Url $url, Oppwa $oppwa, TransactionRepositoryInterface $transactionRepo) {
        $this->url = $url;
        $this->oppwa = $oppwa;
        $this->transactionRepo = $transactionRepo;
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */

    public function index(ResponseRequest $request)
    {
        $response = [];
        if (! $request->input('resourcePath') && !$request->input('id')) {
            abort (403, 'Only authenticated users can access this link.');
        }


        // $request = [
        //     'amount' => 102.34,
        //     'currency' => 'EUR',
        //     'brand' => 'VISA',
        //     'type' => 'DB',
        //     'number' => 4200000000000000,
        //     'holder' => 'Jane Jones',
        //     'expiry_month' => 05,
        //     'expiry_year' => 2020,
        //     'cvv' => 123,
        //     'optionalParameters' => [],
        // ];
        // $response = $this->oppwa->checkout($request)->pay();


        $integration = [];

        $transaction = $this->transactionRepo->findTransactionByResponseId($request->input('id'));

        if ($transaction) {
            $integration = (array)$transaction['request'];
            $response = $this->oppwa->status($request->input('id'), $integration['entityId'], $integration['authorization']);

            if ($response) {
                $transactionLoad = [
                    'credentialid' => $transaction['id'],
                    'transaction_type' => 'payment',
                    'datetime_request' => Carbon::now(),
                    'request' => json_encode($request->all()),
                    'datetime_response' => Carbon::now(),
                    'response_id' => $request->input('id'),
                   'response_status' => $response->status,
                   'response' => json_encode((array)$response)
                ];

               $this->transactionRepo->createTransaction($transactionLoad);
            }


            $response = array_merge((array)$response, $request->all(), $integration);

            $response['amount_formatted'] = $this->formatReadable($integration['currency_code'], $this->format($integration['amount']));

            // echo '<pre>';
            // print_r($response);
            // //print_r($integration);
            // echo '</pre>';
            // echo '<pre>';
            // print_r($response);
            // print_r($integration);
            // echo '</pre>';

            return view('oppwa::response', compact('response', 'integration'));
        }

    }

}
