<?php
/**
 * Definition of OnError
 *
 * @author Marco Stoll <marco@fast-forward-encoding.de>
 * @copyright 2019-forever Marco Stoll
 * @filesource
 */
declare(strict_types=1);

namespace FF\Runtime\Events;

use FF\Events\AbstractEvent;

/**
 * Class OnError
 *
 * @package FF\Runtime\Events
 */
class OnError extends AbstractEvent
{
    /**
     * @var int
     */
    protected $errNo;

    /**
     * @var string
     */
    protected $errMsg;

    /**
     * @var string
     */
    protected $errFile;

    /**
     * @var int
     */
    protected $errLine;

    /**
     * @var array
     */
    protected $errContext;

    /**
     * @param int $errNo
     * @param string $errMsg
     * @param string $errFile
     * @param int $errLine
     * @param array $errContext
     */
    public function __construct(
        int $errNo,
        string $errMsg,
        string $errFile = '',
        int $errLine = null,
        array $errContext = []
    ) {
        $this->errNo = $errNo;
        $this->errMsg = $errMsg;
        $this->errFile = $errFile;
        $this->errLine = $errLine;
        $this->errContext = $errContext;
    }

    /**
     * @return int
     */
    public function getErrNo(): int
    {
        return $this->errNo;
    }

    /**
     * @return string
     */
    public function getErrMsg(): string
    {
        return $this->errMsg;
    }

    /**
     * @return string
     */
    public function getErrFile(): string
    {
        return $this->errFile;
    }

    /**
     * @return int
     */
    public function getErrLine(): int
    {
        return $this->errLine;
    }

    /**
     * @return array
     */
    public function getErrContext(): array
    {
        return $this->errContext;
    }
}