<?php

namespace Werp\Modules\Core\Maintenance\Services;

use Werp\Modules\Core\Maintenance\Models\Doctype;

class DoctypeService
{
    public function __construct(Doctype $doctype)
    {
        $this->doctype = $doctype;
    }

    public function nextDocNumber($id)
    {
    	$doctype = $this->doctype->find($id);
    	$nextNumber = $doctype->last_number + $doctype->increment_number;
    	$doctype->last_number = $nextNumber;
    	$doctype->save();

    	if ($doctype->use_zeros == 'y') {
    		// allow to store the character to repeat like '0'
    		$nextNumber = str_pad($nextNumber, $doctype->number_long, '0', STR_PAD_LEFT);
    	}

    	return $doctype->prefix . $nextNumber;
    }
}
