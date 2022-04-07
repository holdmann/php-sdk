<?php
/**
 * Created by PhpStorm.
 * User: dmitrijganin
 * Date: 2019-10-05
 * Time: 11:41
 */


namespace Mindbox\DTO\V3\Requests;

use Mindbox\DTO\DTO,
    Mindbox\DTO\V3\IdentityDTO;

/**
 * Class OrderRequestDTO
 *
 * @package Mindbox\DTO\V3
 * @property array $ids
 */
class OrderRequestDTO extends DTO
{
    use IdentityDTO;


    public function setId($name, $value)
    {
        $ids        = is_array($this->getIds()) ? $this->getIds() : [];
        $ids[$name] = $value;
        $this->setIds($ids);
    }

    /**
     * @param array $ids
     */
    public function setIds($ids)
    {
        $this->setField('ids', $ids);
    }


}


