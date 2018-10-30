<?php namespace Udla\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Udla\Helpers\UtilsHelper
 */
class Utils extends Facade
{
  /**
   * Get the registered name of the component.
   *
   * @return string
   */
  protected static function getFacadeAccessor()
  {
      return 'utils';
  }
}
