<?php

namespace Mindbox\DTO\V3\Requests;

use Mindbox\DTO\DTO;
use Mindbox\DTO\V3\IdentityDTO;

/**
 * Class RecommendationRequestDTO
 *
 * @package Mindbox\DTO\V3\Requests
 * @property array $ids
 */
class RecommendationRequestDTO extends DTO
{
    use IdentityDTO;

    /**
     * @var string Название элемента для корректной генерации xml.
     */
    protected static $xmlName = 'recommendation';

    protected static $DTOMap = [
        'productCategory' => ProductCategoryDTO::class,
        'product' => ProductIdentityRequestDTO::class,
    ];

    /**
     * @param mixed $limit
     */
    public function setLimit($limit)
    {
        $this->setField('limit', $limit);
    }

    /**
     * @param $product
     * @return void
     */
    public function setProduct($product)
    {
        $this->setField('product', $product);
    }

    /**
     * @param mixed $category
     */
    public function setProductCategory($category)
    {
        $this->setField('productCategory', $category);
    }
}
