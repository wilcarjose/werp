<?php

namespace Werp\Modules\Core\Maintenance\Services;

use Werp\Modules\Core\Base\Services\BaseService;
use Werp\Modules\Core\Maintenance\Models\Config;
use Werp\Modules\Core\Maintenance\Models\AmountOperation;

class AmountOperationService extends BaseService
{
    protected $config;
	protected $entity;
	protected $operation;

    public function __construct(AmountOperation $entity, Config $config)
    {
        $this->entity = $entity;
        $this->config = $config;
    }

    public function getByName($name)
    {
        return $this->entity->where('name', $name)->first();
    }

    public function setOperation($operation)
    {
    	$this->operation = $operation;

    	return $this;
    }

    public function calculate($amount)
    {
    	if (!$this->operation) {
    		return $amount;
    	}

    	$result = 0.0000;

    	// VERIFICAR CONFIG KEY
    	$value = empty($this->operation->config_key) ?
            $this->operation->value :
            $this->config->where('key', $this->operation->config_key)->firstOrFail()->value;

        if ($this->operation->operation == 'multiply') {
            $result = $amount * $value;
        }
        
        if ($this->operation->operation == 'add_amount') {
            $result = $amount + $value;
        }

        if ($this->operation->operation == 'sub_amount') {
            $result = $amount - $value;
        }

        if ($this->operation->operation == 'add_percent') {
            $percent = $amount * $value / 100;
            $result = $amount + $percent;
        }

        if ($this->operation->operation == 'sub_percent') {
            $percent = $amount * $value / 100;
            $result = $amount - $percent;
        }

        return round($result, $this->operation->round, PHP_ROUND_HALF_UP);
    }

    public function getPercentAmount($amount)
    {
    	$percent = 0.0000;

    	if (!$this->operation) {
    		return $percent;
    	}

    	$value = empty($this->operation->config_key) ? $this->operation->value : 100;

    	if ($this->operation->operation == 'add_percent' || $this->operation->operation == 'sub_percent') {
    		$percent = $amount * $value / 100;
    	}

    	return round($percent, $this->operation->round, PHP_ROUND_HALF_UP);
    }
}