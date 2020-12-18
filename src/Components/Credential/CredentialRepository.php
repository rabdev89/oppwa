<?php

namespace Rabcreatives\Oppwa\Components\Credential;

use Rabcreatives\Oppwa\Components\Base\Repositories\BaseRepository;
use Rabcreatives\Oppwa\Components\Credential\Exceptions\CredentialCreateErrorException;
use Rabcreatives\Oppwa\Components\Credential\Exceptions\CredentialUpdateErrorException;
use Rabcreatives\Oppwa\Components\Credential\Exceptions\CredentialNotFoundException;
use Rabcreatives\Oppwa\Components\Credential\Transformations\CredentialTransformable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Rabcreatives\Oppwa\Components\Interfaces\CredentialRepositoryInterface;

class CredentialRepository extends BaseRepository  implements CredentialRepositoryInterface
{
    use CredentialTransformable;

    /**
     * CredentialRepository constructor.
     * @param Credential $credential
     */
    public function __construct(Credential $credential)
    {
        parent::__construct($credential);
        $this->model = $credential;
    }

    /**
     * List all the expenses
     *
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return Collection
     */
    public function listCredential(string $order = 'id', string $sort = 'desc', array $columns = ['*']) : Collection
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * Create the Credential
     *
     * @param array $data
     *
     * @return Credential
     * @throws CredentialCreateErrorException
     */
    public function createCredential(array $data) : Credential
    {
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new CredentialCreateErrorException($e);
        }
    }

    /**
     * Update the Credential
     *
     * @param array $data
     *
     * @return bool
     * @throws CredentialUpdateErrorException
     */
    public function updateCredential(array $data) : bool
    {
        $filtered = collect($data)->all();

        try {
            return $this->model->where('id', $this->model->id)->update($filtered);
        } catch (QueryException $e) {
            throw new CredentialUpdateErrorException($e);
        }
    }

    /**
     * Find the Credential by ID
     *
     * @param int $id
     *
     * @return Credential
     * @throws CredentialNotFoundException
     */
    public function findCredentialById(int $id) : Credential
    {
        try {
            return $this->credentialSimpleTransform($this->findOneOrFail($id));
        } catch (ModelNotFoundException $e) {
            throw new CredentialNotFoundException($e);
        }
    }

        /**
     * Find the Credential by ID
     *
     * @param int $id
     *
     * @return Credential
     * @throws CredentialNotFoundException
     */
    public function findCredentialByConfigId(int $id) : Credential
    {
        try {
            return $this->credentialTransform($this->findOneBy(['configurationid'=>$id]));
        } catch (ModelNotFoundException $e) {
            throw new CredentialNotFoundException($e);
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function removeCredential() : bool
    {
        return $this->model->where('id', $this->model->id)->delete();
    }


    /**
     * @param string $text
     * @return mixed
     */
    public function searchCredential(string $text) : Collection
    {
        if (!empty($text)) {
            return $this->model->searchCredential($text);
        } else {
            return $this->listCredential();
        }
    }


}
