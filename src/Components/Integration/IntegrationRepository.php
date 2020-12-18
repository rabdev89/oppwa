<?php

namespace Rabcreatives\Oppwa\Components\Integration;

use Rabcreatives\Oppwa\Components\Base\Repositories\BaseRepository;
use Rabcreatives\Oppwa\Components\Integration\Exceptions\IntegrationCreateErrorException;
use Rabcreatives\Oppwa\Components\Integration\Exceptions\IntegrationUpdateErrorException;
use Rabcreatives\Oppwa\Components\Integration\Exceptions\IntegrationNotFoundException;
use Rabcreatives\Oppwa\Components\Integration\Transformations\IntegrationTransformable;
use Rabcreatives\Oppwa\Components\Integration\Integration;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Rabcreatives\Oppwa\Components\Interfaces\IntegrationRepositoryInterface;

class IntegrationRepository extends BaseRepository  implements IntegrationRepositoryInterface
{
    use IntegrationTransformable;

    /**
     * IntegrationRepository constructor.
     * @param Integration $integration
     */
    public function __construct(Integration $integration)
    {
        parent::__construct($integration);
        $this->model = $integration;
    }

    /**
     * List all the expenses
     *
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return Collection
     */
    public function listIntegration(string $order = 'id', string $sort = 'desc', array $columns = ['*']) : Collection
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * Create the Integration
     *
     * @param array $data
     *
     * @return Integration
     * @throws IntegrationCreateErrorException
     */
    public function createIntegration(array $data) : Integration
    {
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new IntegrationCreateErrorException($e);
        }
    }

    /**
     * Update the Integration
     *
     * @param array $data
     *
     * @return bool
     * @throws IntegrationUpdateErrorException
     */
    public function updateIntegration(array $data) : bool
    {
        $filtered = collect($data)->all();

        try {
            return $this->model->where('id', $this->model->id)->update($filtered);
        } catch (QueryException $e) {
            throw new IntegrationUpdateErrorException($e);
        }
    }

    /**
     * Find the Integration by ID
     *
     * @param int $id
     *
     * @return Integration
     * @throws IntegrationNotFoundException
     */
    public function findIntegrationById(int $id) : Integration
    {
        try {
            return $this->transformSimple($this->findOneOrFail($id));
        } catch (ModelNotFoundException $e) {
            throw new IntegrationNotFoundException($e);
        }
    }

    /**
     * Find the Integration by APN Credential
     *
     * @param int $id
     *
     * @return Integration
     * @throws IntegrationNotFoundException
     */
    public function findIntegrationByApnCredential(int $registrationId) : Integration
    {
        try {
            $organziation = $this->findOneBy(['zoho_apn_credential' => $registrationId]);

            return $this->transformSimple($organziation);
        } catch (ModelNotFoundException $e) {
            throw new IntegrationNotFoundException($e);
        }
    }

    /**
     * Delete the expenses
     *
     * @param Integration $integration
     *
     * @return bool
     * @throws \Exception
     * @deprecated
     * @use removeIntegration
     */
    public function deleteIntegration() : bool
    {
        return $this->delete();
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function removeIntegration() : bool
    {
        return $this->model->where('integrationid', $this->model->id)->delete();
    }


    /**
     * @param string $text
     * @return mixed
     */
    public function searchIntegration(string $text) : Collection
    {
        if (!empty($text)) {
            return $this->model->searchIntegration($text);
        } else {
            return $this->listIntegration();
        }
    }


}
