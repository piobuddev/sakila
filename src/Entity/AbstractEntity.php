<?php declare(strict_types=1);

namespace Sakila\Entity;

use Sakila\Utils\Fillable;
use Sakila\Utils\StringUtil;

class AbstractEntity implements EntityInterface
{
    use Fillable;

    /**
     * Specify data which should be serialized to JSON
     * @link  http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize(): array
    {
        $vars = get_object_vars($this);
        foreach ($vars as $property => &$value) {
            $method = StringUtil::prefix('get', ucfirst($property));
            if (method_exists($this, $method)) {
                $value = call_user_func([$this, $method]);
            }
        };

        return $vars;
    }
}
