<?php

namespace Werp\Modules\Core\Maintenance\Services;

use Werp\Modules\Core\Base\Services\BaseService;
use Werp\Modules\Core\Maintenance\Models\AmountOperation;

class AmountOperationService extends BaseService
{
	protected $entity;
	protected $operation;

    public function __construct(AmountOperation $entity)
    {
        $this->entity = $entity;
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
    	$value = empty($this->operation->config_key) ? $this->operation->value : 100;

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