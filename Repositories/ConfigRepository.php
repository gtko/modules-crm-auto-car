<?php

namespace Modules\CrmAutoCar\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\BaseCore\Repositories\AbstractRepository;
use Modules\CrmAutoCar\Contracts\Repositories\ConfigsRepositoryContract;
use Modules\CrmAutoCar\Models\Config;

class ConfigRepository extends AbstractRepository implements ConfigsRepositoryContract
{

    public function getModel(): Model
    {
        return new Config();
    }

    public function searchQuery(Builder $query, string $value, mixed $parent = null): Builder
    {
        // TODO: Implement searchQuery() method.
    }

    public function create(string $name, array $data): Config
    {
        $config = new Config();
        $config->name = $name;
        $config->data = $data;
        $config->save();

        return $config;
    }

    public function update(Config $config, array $data): Config
    {
       $config->data = $data;
       $config->save();

       return $config;
    }

    public function getByName(string $name): Config | null
    {
        return Config::where('name', $name)->first();
    }
}
