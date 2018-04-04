<?php declare(strict_types=1);

namespace Sakila\Command\Bus;

use Sakila\Command\Command;

interface CommandBus
{
    /**
     * @param \Sakila\Command\Command $command
     *
     * @return mixed
     */
    public function execute(Command $command);
}
