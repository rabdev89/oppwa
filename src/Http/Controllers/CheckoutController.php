<?php

namespace Rabcreatives\Oppwa\Http\Controllers;
use Illuminate\Http\Request;
use Rabcreatives\Oppwa\Helpers\Url;
use Rabcreatives\Oppwa\Oppwa;
use Rabcreatives\Oppwa\Traits\CurrencyTraits;
use Rabcreatives\Oppwa\Components\Interfaces\IntegrationRepositoryInterface;
use Rabcreatives\Oppwa\Components\Interfaces\ConfigurationRepositoryInterface;
use Rabcreatives\Oppwa\Components\Interfaces\TransactionRepositoryInterface;
use Rabcreatives\Oppwa\Components\Interfaces\CredentialRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    use CurrencyTraits;
    /**
     * @var Url
     */
    private $url;

    private $oppwaClient;

    private $oppwa;

    /**
     * @var IntegrationRepositoryInterface
     */
    private $integrationRepo;

    /**
     * @var ConfigurationRepositoryInterface
     */
    private $configRepo;


    /**
     * @var TransactionRepositoryInterface
     */
    private $transactionRepo;

    /**
     * @var CredentialRepositoryInterface
     */
    private $credentialRepo;

    /**
     * CheckoutController constructor.
     *
     * @param IntegrationRepositoryInterface $roleRepository
     * @param ConfigurationRepositoryInterface $configRepo
     * @param TransactionRepositoryInterface $transactionRepo
     * @param CredentialRepositoryInterface $credentialRepo
     *
     */
    public function __construct(
        Url $url,
        Oppwa $oppwa,
        IntegrationRepositoryInterface $integrationRepo,
        ConfigurationRepositoryInterface $configRepo,
        TransactionRepositoryInterface $transactionRepo,
        CredentialRepositoryInterface $credentialRepo
    ) {
        $this->url = $url;
        $this->oppwa = $oppwa;
        $this->integrationRepo = $integrationRepo;
        $this->transactionRepo = $transactionRepo;
        $this->credentialRepo = $credentialRepo;
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        if (! $request->all()) {
            abort (403, 'Only authenticated users can access this link.');
        }

        $integration = $this->integrationRepo->findIntegrationByApnCredential($request->input('organization_id'));

        if (! $integration) {
            abort (404, 'Organization Id is required.');
        }

        $url = $this->url->fromString(url()->full());
        $url = $url->getQuery();

        $response = $request->all();
        $response['amount_formatted'] = $this->formatReadable($response['currency_code'], $this->format($response['amount']));

        $paymentTypes = $integration->configuration;

        // echo '<!--<pre>';
        // //print_r($integration);
        // //print_r($paymentTypes);

        // //print_r($request->all());
        // echo '</pre>-->';


        return view('oppwa::index', compact('paymentTypes', 'url', 'integration', 'response'));
    }

    public function type(Request $request, String $type)
    {
        if (! $type) {
            abort (403, 'Only authenticated users can access this link.');
        }
        $response = [];
        $integration = $this->integrationRepo->findIntegrationByApnCredential($request->input('organization_id'));

        $credential = [];
        foreach ($integration->configuration as $key => $configuration) {
           if ($configuration['payment_brand'] === $type) {
               $credential = $configuration;
           }
        }

        $credentialData = $this->credentialRepo->findCredentialByConfigId($credential['configurationid']);

        $payload = [
            'brand' => 'CHECKOUT',
            'amount' => $request->input('amount'),
            'currency' => $request->input('currency_code'),
            'type' => $request->input('payment_type') ? $request->input('payment_type') : config('oppwa.oppwa_payment_type'),
            'optionalParameters' => [],
            'entityId' => $credentialData['entity'],
            'userId' => $integration->zoho_account,
            'password' => $integration->zoho_apn_account,
            'authorization' => $credentialData['bearer'],
        ];
        $response = $oppwaResponse = $this->oppwa->checkout($payload)->pay();

        $response = array_merge((array)$response, $request->all());

        $response['id'] = $response['response']->id;
        $response['payment_type_selected']= $type;
        $response['shopperResultUrl'] = url('response');
        $response['amount_formatted'] = $this->formatReadable($response['currency_code'], $this->format($response['amount']));

        $integrationWithRequest = array_merge($integration->toArray(), $request->all(), $payload);

        $transactionLoad = [
            'credentialid' => $credentialData['id'],
            'transaction_type' => 'checkout',
            'datetime_request' => Carbon::now(),
            'request' => json_encode($integrationWithRequest),
            'datetime_response' => Carbon::now(),
            'response_id' => $oppwaResponse->response->id,
            'response_status' => $oppwaResponse->status,
            'response' => json_encode($oppwaResponse)
        ];

        $transactionData = $this->transactionRepo->createTransaction($transactionLoad);

        // echo '<pre>';
        // print_r($integrationWithRequest);
        // //print_r($response);
        // echo '</pre>';



        return view('oppwa::checkout', compact('response', 'integration'));
    }

    public function store(Request $request, String $type)
    {
        if (! $type) {
            abort (403, 'Only authenticated users can access this link.');
        }

        $integration = $this->integrationRepo->findIntegrationByApnCredential($request->input('organization_id'));

        session(['integration' => $integration->toArray()]);

        $credential = [];
        foreach ($integration->configuration as $key => $configuration) {
           if ($configuration['payment_brand'] === $type) {
               $credential = $configuration;
           }
        }

        $response['id'] = $response['response']->id;
        $response['payment_type_selected']= $type;
        $response['shopperResultUrl'] = url('response');
        $response['amount_formatted'] = $this->formatReadable($response['currency_code'], $this->format($response['amount']));

        $credentialData = $this->credentialRepo->findCredentialByConfigId($credential['configurationid']);

        $transactionLoad = [
            'credentialid' => $credentialData['id'],
            'transaction_type' => 'checkout',
            'datetime_request' => Carbon::now(),
            'request' => json_encode(array_merge($integration, $request->all())),
            'datetime_response' => Carbon::now(),
            'response_id' => $oppwaResponse->response->id,
            'response_status' => $oppwaResponse->status,
            'response' => json_encode($oppwaResponse)
        ];

        $transactionData = $this->transactionRepo->createTransaction($transactionLoad);

        // echo '<pre>';
        // print_r($credentialData['id']);
        // print_r(session('integration'));
        // print_r($response);
        // echo '</pre>';



        return Redirect::to('/checkout/'.$type)->withInput($request->all());
    }

}
