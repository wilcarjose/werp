<?php

namespace Werp\Modules\Core\Products\Services;

use Werp\Modules\Core\Maintenance\Models\Config;

class ConfigService
{
    protected $config;
    protected $configObject;
    protected $selectsConfig;
    protected $transactionService;

    public function __construct(
        Config $config
    ) {
        $this->config = $config;

        $this->selectsConfig = [
            'doctypes' => 'inv_default_inventory_doctype',
            'warehouses' => 'inv_default_warehouse'
        ];
    }

    public function getConfig()
    {
        $configs = [];

        $configs['selects'] = $this->getSelects();

        return $configs;
    }

    protected function getSelects()
    {
        $configs = $this->config->whereIn('key', $this->selectsConfig)->get();

        $data = [];

        foreach ($configs as $config) {
    
            $data[] = [
                'key' => $config->key,
                'value' => $config->value,
                'translate_key' => $config->translate_key,
                'type' => 'select',
                'options' => $this->getSelectKey($config->key)
            ];
        }

        return $data;
    }

    protected function getSelectKey($option)
    {
        foreach ($this->selectsConfig as $key => $select) {
            if ($select == $option) {
                return $key;
            }
        }
    }

    public function updateConfig($data)
    {
        foreach ($this->selectsConfig as $key) {
            if (isset($data[$key])) {
                $config = $this->config->where('key', $key)->first();
                $config->value = $data[$key];
                $config->save();
            }
        }
    }

    public function getDefaultInventaryDoctype()
    {
        return $this->getValue('inv_default_inventory_doctype');
    }

    public function getDefaultPriceListDoctype()
    {
        return $this->getValue('pri_default_price_list_doctype');
    }

    public function getDefaultWarehouse()
    {
        return $this->getValue('inv_default_warehouse');
    }

    public function getValue($key)
    {
        $config = $this->config->where('key', $key)->first();

        if ($config) {
            return $config->value;
        }

        return null;
    }
}
