<?php declare(strict_types=1);

namespace Sakila\Transformer;

interface TransformerInterface
{
    /**
     * @param mixed       $data
     * @param string|null $transformer
     *
     * @return mixed
     */
    public function item($data, string $transformer = null);

    /**
     * @param mixed       $data
     * @param string|null $transformer
     * @param int|null    $page
     * @param int|null    $pageSize
     * @param int|null    $total
     *
     * @return mixed
     */
    public function collection(
        $data,
        string $transformer = null,
        int $page = null,
        int $pageSize = null,
        int $total = null
    );
}
