<?php
/**
 * Definition of OnException
 *
 * @author Marco Stoll <marco@fast-forward-encoding.de>
 * @copyright 2019-forever Marco Stoll
 * @filesource
 */
declare(strict_types=1);

namespace FF\Runtime\Events;

use FF\Events\AbstractEvent;

/**
 * Class OnException
 *
 * @package FF\Runtime\Events
 */
class OnException extends AbstractEvent
{
    /**
     * @var \Throwable
     */
    protected $exception;

    /**
     * @param \Throwable $exception
     */
    public function __construct(\Throwable $exception)
    {
        $this->exception = $exception;
    }

    /**
     * @return \Throwable
     */
    public function getException(): \Throwable
    {
        return $this->exception;
    }
}