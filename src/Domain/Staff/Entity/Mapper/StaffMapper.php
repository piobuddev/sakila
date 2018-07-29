<?php declare(strict_types=1);

namespace Sakila\Domain\Staff\Entity\Mapper;

use Sakila\Entity\Mapper\AbstractMapper;

class StaffMapper extends AbstractMapper
{
    /**
     * @return array
     */
    protected function getMapping(): array
    {
        return [
            'staffId'   => 'staff_id',
            'firstName' => 'first_name',
            'lastName'  => 'last_name',
            'addressId' => 'address_id',
            'picture'   => 'picture',
            'email'     => 'email',
            'storeId'   => 'store_id',
            'active'    => 'active',
            'username'  => 'username',
            'password'  => 'password',
        ];
    }
}
