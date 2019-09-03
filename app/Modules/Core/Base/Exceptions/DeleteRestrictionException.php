<?php

namespace Werp\Modules\Core\Base\Exceptions;

class DeleteRestrictionException extends \Exception {

  public function getStatusCode()
  {
    return 403;
  }
}