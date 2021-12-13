<?php

namespace Modules\CrmAutoCar\Contracts\Repositories;

use Modules\CrmAutoCar\Models\Config;

interface ConfigsRepositoryContract
{
    public function create(string $name, array $data):Config;
    public function update(Config $config, array $data):Config;
    public function getByName(string $name):Config | null;
}
