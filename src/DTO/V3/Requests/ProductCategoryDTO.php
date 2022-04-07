<?php

namespace Mindbox\DTO\V3\Requests;

use Mindbox\DTO\DTO;
use Mindbox\DTO\V3\IdentityDTO;

/**
 * Class ProductCategoryDTO
 **/
class ProductCategoryDTO extends DTO
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