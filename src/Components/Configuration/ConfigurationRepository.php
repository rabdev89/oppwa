<?php

namespace Rabcreatives\Oppwa\Components\Configuration;

use Rabcreatives\Oppwa\Components\Base\Repositories\BaseRepository;
use Rabcreatives\Oppwa\Components\Configuration\Exceptions\ConfigurationCreateErrorException;
use Rabcreatives\Oppwa\Components\Configuration\Exceptions\ConfigurationUpdateErrorException;
use Rabcreatives\Oppwa\Components\Configuration\Exceptions\ConfigurationNotFoundException;
use Rabcreatives\Oppwa\Components\Configuration\Transformations\ConfigurationTransformable;
use Rabcreatives\Oppwa\Components\Configuration\Configuration;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Rabcreatives\Oppwa\Components\Interfaces\ConfigurationRepositoryInterface;

class ConfigurationRepository extends BaseRepository  implements ConfigurationRepositoryInterface
{
    use ConfigurationTransformable;

    /**
     * ConfigurationRepository constructor.
     * @param Configuration $configuration
     */
    public function __construct(Configuration $configuration)
    {
        parent::__construct($configuration);
        $this->model = $configuration;
    }

    /**
     * List all the expenses
     *
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return Collection
     */
    public function listConfiguration(string $order = 'configurationid', string $sort = 'desc', array $columns = ['*']) : Collection
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * Create the Configuration
     *
     * @param array $data
     *
     * @return Configuration
     * @throws ConfigurationCreateErrorException
     */
    public function createConfiguration(array $data) : Collection
    {
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new ConfigurationCreateErrorException($e);
        }
    }

    /**
     * Update the Configuration
     *
     * @param array $data
     *
     * @return bool
     * @throws ConfigurationUpdateErrorException
     */
    public function updateConfiguration(array $data) : bool
    {
        $filtered = collect($data)->all();

        try {
            return $this->model->where('configurationid', $this->model->configurationid)->update($filtered);
        } catch (QueryException $e) {
            throw new ConfigurationUpdateErrorException($e);
        }
    }

    /**
     * Find the Configuration by ID
     *
     * @param int $id
     *
     * @return Configuration
     * @throws ConfigurationNotFoundException
     */
    public function findConfigurationById(int $id) : Collection
    {
        try {
            return $this->transformSimple($this->findOneOrFail($id));
        } catch (ModelNotFoundException $e) {
            throw new ConfigurationNotFoundException($e);
        }
    }

    /**
     * @return Collection
     */
    public function listIntegration(): Collection
    {
        return $this->model->integration()->get();
    }


    /**
     * Delete the expenses
     *
     * @param Configuration $configuration
     *
     * @return bool
     * @throws \Exception
     * @deprecated
     * @use removeConfiguration
     */
    public function deleteConfiguration() : bool
    {
        return $this->delete();
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function removeConfiguration() : bool
    {
        return $this->model->where('configurationid', $this->model->configurationid)->delete();
    }


    /**
     * @param string $text
     * @return mixed
     */
    public function searchConfiguration(string $text) : Collection
    {
        if (!empty($text)) {
            return $this->model->searchConfiguration($text);
        } else {
            return $this->listConfiguration();
        }
    }


}
