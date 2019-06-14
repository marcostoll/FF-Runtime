<?php
/**
 * Definition of ShutdownHandler
 *
 * @author Marco Stoll <marco@fast-forward-encoding.de>
 * @copyright 2019-forever Marco Stoll
 * @filesource
 */
declare(strict_types=1);

namespace FF\Runtime;

use FF\Events\EventBroker;

/**
 * Class ErrorHandler
 *
 * @package FF\Runtime
 */
class ShutdownHandler implements RuntimeEventHandlerInterface
{
    /**
     * List of codes indicating fatal errors
     */
    const FATAL_ERRORS = [
        E_ERROR,
        E_PARSE,
        E_CORE_ERROR,
        E_COMPILE_ERROR,
        E_USER_ERROR,
        E_RECOVERABLE_ERROR
    ];

    /**
     * @var bool
     */
    protected $forceExit;

    /**
     * @param bool $forceExit
     */
    public function __construct(bool $forceExit = false)
    {
        $this->forceExit = $forceExit;
    }

    /**
     * {@inheritdoc}
     *
     * @return $this
     * @see http://php.net/register_shutdown_function
     */
    public function register()
    {
        register_shutdown_function([$this, 'onShutdown']);
        return $this;
    }

    /**
     * @return bool
     */
    public function getForceExit(): bool
    {
        return $this->forceExit;
    }

    /**
     * @param bool $forceExit
     * @return $this
     */
    public function setForceExit(bool $forceExit)
    {
        $this->forceExit = $forceExit;
        return $this;
    }

    /**
     * Generic shutdown handler callback
     *
     * Terminates further execution via exit() if configured to do so,
     * thus stopping any additional shutdown handlers from being called.
     *
     * Fires an additional OnError event, in case a fatal error is detected
     *
     * @fires Runtime\OnShutdown
     * @fires Runtime\OnError
     * @see http://php.net/register_shutdown_function
     * @see http://php.net/error_get_last
     */
    public function onShutdown()
    {
        $error = error_get_last();
        if (!is_null($error) && in_array($error['type'], self::FATAL_ERRORS)) {
            EventBroker::getInstance()->fire(
                'Runtime\OnError',
                $error['type'],
                $error['message'],
                $error['file'],
                $error['line']
            );
        }

        EventBroker::getInstance()->fire('Runtime\OnShutdown');

        if ($this->forceExit) exit();
    }
}