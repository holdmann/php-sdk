<?php

namespace Mindbox\Helpers;

use \Mindbox\DTO\V3\Requests\CustomerRequestDTO,
    \Mindbox\DTO\V3\Requests\RecommendationRequestDTO,
    \Mindbox\MindboxResponse;

class RecommendationHelper extends AbstractMindboxHelper
{
    public function getRecomendations(
        RecommendationRequestDTO $recommendation,
        $operationName,
        $addDeviceUUD = false
    )
    {
        $operation = $this->createOperation();
        $operation->setRecomendation($recommendation);

        $this->client->setResponseType(MindboxResponse::class);

        return $this->client->prepareRequest('POST', $operationName, $operation, '', [], true, $addDeviceUUD);
    }

}
