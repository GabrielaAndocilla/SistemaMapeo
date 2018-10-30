<?php
namespace Udla\Helpers;
use Udla\Model\Career;
use Exception;

class UtilsHelper
{
  public function __construct(){
  }

  public function getCarrera($id)
  {

    return Career::carrera($id);
  }
}
