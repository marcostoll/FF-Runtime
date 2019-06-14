<?php
/**
 * Definition of RuntimeEventHandlerInterface
 *
 * @author Marco Stoll <marco@fast-forward-encoding.de>
 * @copyright 2019-forever Marco Stoll
 * @filesource
 */
declare(strict_types=1);

namespace FF\Runtime;

/**
 * Interface RuntimeEventHandlerInterface
 *
 * @package FF\Runtime
 */
interface RuntimeEventHandlerInterface
{
    /**
     * Registers the handler to some runtime event
     *
     * @return $this
     */
    public function register();
}