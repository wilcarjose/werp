<?php

namespace Werp\Modules\Core\Maintenance\Services;

use Werp\Modules\Core\Maintenance\Models\Config;
use Werp\Modules\Core\Maintenance\Models\Basedoc;
use Werp\Modules\Core\Maintenance\Models\Currency;
use Werp\Modules\Core\Maintenance\Services\PriceListTypeService;

class ConfigService
{
    protected $config;
    protected $configObject;
    protected $docsConfig;
    protected $priceListTypeService;

    public function __construct(
        Config $config,
        PriceListTypeService $priceListTypeService

    ) {
        $this->config = $config;
        $this->priceListTypeService = $priceListTypeService;

        $this->docsConfig = [
            Basedoc::IN_DOC => Config::INV_DEFAULT_IN_DOC,
            Basedoc::PL_DOC => Config::PRI_DEFAULT_PL_DOC,
            Basedoc::IE_DOC => Config::INV_DEFAULT_IE_DOC,
            Basedoc::PO_DOC => Config::INV_DEFAULT_PO_DOC,
            Basedoc::IO_DOC => Config::INV_DEFAULT_IO_DOC,
            Basedoc::SO_DOC => Config::INV_DEFAULT_SO_DOC,
            Basedoc::IM_DOC => Config::INV_DEFAULT_IM_DOC,
            Basedoc::PI_DOC => Config::PUR_DEFAULT_PI_DOC,
            Basedoc::SI_DOC => Config::SAL_DEFAULT_SI_DOC,
        ];

        $this->productsConfig = [
            Config::INV_DEFAULT_WAREHOUSE,
        ];

        $this->inputsConfig = [
            //Config::CURRENT_DOLAR_CONVERSION,
        ];

        $this->currenciesConfig = [
            Config::MAI_DEFAULT_CURRENCY,
            Config::MAI_BASE_CURRENCY,
        ];
    }

    public function getConfig()
    {
        $configs = [];

        $configs['docs'] = $this->getDocs();
        $configs['products'] = $this->getProducts();
        $configs['inputs'] = $this->getInputs();
        $configs['currencies'] = $this->getCurrencies();

        return $configs;
    }

    protected function getInputs()
    {
        $data = [];

        foreach ($this->inputsConfig as $value) {

            $config = $this->config->where('key', $value)->first();

            $data[] = [
                'key' => $config->key,
                'value' => $config->value,
                'translate_key' => $config->translate_key,
                'type' => 'input',
            ];
        }

        return $data;
    }

    protected function getDocs()
    {
        $data = [];

        foreach ($this->docsConfig as $key => $value) {

            $config = $this->config->where('key', $value)->first();

            $data[] = [
                'doc' => $key,
                'key' => $config->key,
                'value' => $config->value,
                'translate_key' => $config->translate_key,
                'type' => 'select',
                'options' => $this->getSelectKey($config->key)
            ];
        }

        return $data;
    }

    public function getCurrencies()
    {
        $data = [];

        foreach ($this->currenciesConfig as $key => $value) {

            $config = $this->config->where('key', $value)->first();

            $data[] = [
                'doc' => $key,
                'key' => $config->key,
                'value' => $config->value,
                'translate_key' => $config->translate_key,
                'type' => 'select',
                'options' => $this->getSelectKey($config->key)
            ];
        }

        return $data;
    }

    protected function getProducts()
    {
        $data = [];

        foreach ($this->productsConfig as $value) {

            $config = $this->config->where('key', $value)->first();

            $data[] = [
                'key' => $config->key,
                'value' => $config->value,
                'translate_key' => $config->translate_key,
                'type' => 'select',
                'options' => $this->getSelectKey($config->key),
                'select' => 'warehouse'
            ];
        }

        return $data;
    }

    protected function getSelectKey($option)
    {
        foreach ($this->docsConfig as $key => $select) {
            if ($select == $option) {
                return $key;
            }
        }

        foreach ($this->productsConfig as $key => $select) {
            if ($select == $option) {
                return $key;
            }
        }

        foreach ($this->currenciesConfig as $key => $select) {
            if ($select == $option) {
                return $key;
            }
        }
    }

    public function updateConfig($data)
    {
        foreach ($this->docsConfig as $key) {
            if (isset($data[$key])) {
                $config = $this->config->where('key', $key)->first();
                $config->value = $data[$key];
                $config->save();
            }
        }

        foreach ($this->productsConfig as $key) {
            if (isset($data[$key])) {
                $config = $this->config->where('key', $key)->first();
                $config->value = $data[$key];
                $config->save();
            }
        }

        foreach ($this->inputsConfig as $key) {
            if (isset($data[$key])) {
                $config = $this->config->where('key', $key)->first();
                $config->value = $data[$key];
                $config->save();
            }
        }

        foreach ($this->currenciesConfig as $key) {

            if (isset($data[$key])) {

                if ($key == Config::MAI_DEFAULT_CURRENCY) {

                    $this->priceListTypeService->getOrCreatePriceList($data[$key], 'sales');

                    $this->priceListTypeService->getOrCreatePriceList($data[$key], 'purchases');

                }

                if ($key == Config::MAI_BASE_CURRENCY) {

                    $this->priceListTypeService->getOrCreatePriceList($data[$key], 'sales');

                    $this->priceListTypeService->getOrCreatePriceList($data[$key], 'purchases');

                }

                $config = $this->config->where('key', $key)->first();
                $config->value = $data[$key];
                $config->save();
            }

             if ($this->getValue(Config::MAI_DEFAULT_CURRENCY) && $this->getValue(Config::MAI_DEFAULT_CURRENCY)) {
                session('company')->setComplete('currency');
             }
        }
    }

    public function getDefaultInventaryDoctype()
    {
        return $this->getValue(Config::INV_DEFAULT_IN_DOC);
    }

    public function getDefaultPriceListDoctype()
    {
        return $this->getValue(Config::PRI_DEFAULT_PL_DOC);
    }

    public function getDefaultWarehouse()
    {
        return $this->getValue(Config::INV_DEFAULT_WAREHOUSE);
    }

    public function getValue($key, $default = null)
    {
        $config = $this->config->where('key', $key)->first();

        if ($config && !is_null($config->value) && !empty($config->value)) {
            return $config->value;
        }

        return $default;
    }

    public function updateOrCreate($key, $value, $transKey = null, $name = '', $type = 'text', $module = null)
    {
        $config = $this->config->where('key', $key)->first();

        if (is_null($config)) {
            $data = [
                'key' => $key,
                'value' => $value,
                'translate_key' => $transKey,
                'type' => $type,
                'module' => $module,
                'name' => $name
            ];
            return $this->config->create($data);
        }

        $config->value = $value;
        return $config->save();
    }
}
