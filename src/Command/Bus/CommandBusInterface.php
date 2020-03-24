<?php declare(strict_types=1);

namespace Sakila\Command\Bus;

use Sakila\Command\CommandInterface;

interface CommandBusInterface
{
    /**
     * @param \Sakila\Command\CommandInterface $command
     *
     * @return mixed
     */
    public function execute(CommandInterface $command);
}
