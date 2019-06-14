<?php
/**
 * Definition of ErrorHandler
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
class ErrorHandler implements RuntimeEventHandlerInterface
{
    /**
     * @var callable|null
     */
    protected $previousHandler;

    /**
     * @var int
     */
    protected $errorTypes;

    /**
     * @var bool
     */
    protected $bypassPhpErrorHandling = false;

    /**
     * @param int $errorTypes
     * @param bool $bypassPhpErrorHandling
     */
    public function __construct(int $errorTypes = E_ALL, bool $bypassPhpErrorHandling = false)
    {
        $this->errorTypes = $errorTypes;
        $this->bypassPhpErrorHandling = $bypassPhpErrorHandling;
    }

    /**
     * {@inheritdoc}
     *
     * Replaces the currently registered error handler callback (if any).
     * Stores any previously registered error handler callback.
     *
     * @see http://php.net/set_error_handler
     */
    public function register()
    {
        $this->previousHandler = set_error_handler([$this, 'onError'], $this->errorTypes);
        return $this;
    }

    /**
     * Retrieves the previous error handler callback before registration (if any)
     *
     * If register() wasn't called yet or no previous error handler callback was registered, null will be returned.
     *
     * @return callable|null
     */
    public function getPreviousHandler(): ?callable
    {
        return $this->previousHandler;
    }

    /**
     * Restores the previous error handler (if any)
     *
     * @return $this
     */
    public function restorePreviousHandler()
    {
        if (!is_callable($this->previousHandler)) return $this;

        set_error_handler($this->previousHandler);
        $this->previousHandler = null;

        return $this;
    }

    /**
     * @return int
     */
    public function getErrorTypes(): int
    {
        return $this->errorTypes;
    }

    /**
     * @param int $errorTypes
     * @return $this
     */
    public function setErrorTypes(int $errorTypes)
    {
        $this->errorTypes = $errorTypes;
        return $this;
    }

    /**
     * @return bool
     */
    public function getBypassPhpErrorHandling(): bool
    {
        return $this->bypassPhpErrorHandling;
    }

    /**
     * @param bool $bypassPhpErrorHandling
     * @return $this
     */
    public function setBypassPhpErrorHandling(bool $bypassPhpErrorHandling)
    {
        $this->bypassPhpErrorHandling = $bypassPhpErrorHandling;
        return $this;
    }

    /**
     * Generic error handler callback
     *
     * @param int $errNo
     * @param string $errMsg
     * @param string $errFile
     * @param int $errLine
     * @param array $errContext
     * @return boolean
     * @fires Runtime\OnError
     * @see http://php.net/set_error_handler
     */
    public function onError(
        int $errNo,
        string $errMsg,
        string $errFile = '',
        int $errLine = null,
        array $errContext = []
    ): bool {
        EventBroker::getInstance()->fire('Runtime\OnError', $errNo, $errMsg, $errFile, $errLine, $errContext);

        return $this->bypassPhpErrorHandling;
    }
}