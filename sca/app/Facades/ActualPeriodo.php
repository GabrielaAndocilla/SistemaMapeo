<?php namespace Udla\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Udla\Factory\PeriodoFactory
 */
class ActualPeriodo extends Facade{

  /**
   * Get the registered name of the component.
   *
   * @return string
   */
  protected static function getFacadeAccessor()
  {
      return 'periodo';
  }

}
