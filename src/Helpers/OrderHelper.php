<?php

namespace Mindbox\Helpers;

use Mindbox\DTO\V2\Requests\OrderCreateRequestDTO;
use Mindbox\DTO\V2\Requests\OrderUpdateRequestDTO;
use Mindbox\DTO\V2\Requests\PreorderRequestDTO;
use Mindbox\DTO\V2\Requests\OrderRequestDTO as OrderRequestDTOV2;
use Mindbox\Responses\MindboxOrderResponse;
use Mindbox\Responses\MindboxOrdersResponse;
use Mindbox\DTO\V3\Requests\CustomerRequestDTO;
use Mindbox\DTO\V2\Requests\CustomerRequestDTO as CustomerRequestDTOV2;
use Mindbox\DTO\V3\Requests\OrderRequestDTO;

/**
 * Хелпер, являющий обёрткой над универсальным запросом. Содержит методы для отправки запросов, связанных с
 * процессингом заказов.
 * Class OrderHelper
 *
 * @package Mindbox\Helpers
 */
class OrderHelper extends AbstractMindboxHelper
{
    /**
     * Выполняет вызов стандартной операции Website.CalculateCart:
     *
     * @see https://developers.mindbox.ru/docs/preorderxml
     *
     * @param Mindbox\DTO\V2\Requests\OrderRequestDTO $order         Объект, содержащий данные корзины для запроса.
     * @param Mindbox\DTO\V2\Requests\CustomerRequestDTO $customer      Объект, содержащий данные пользователя для запроса.
     * @param string             $operationName Название операции.
     *
     * @return \Mindbox\Clients\AbstractMindboxClient
     */
    public function calculateCart(
        OrderRequestDTOV2 $order,
        CustomerRequestDTOV2 $customer,
        $operationName
    )
    {
        $this->client->setResponseType(MindboxOrderResponse::class);

        $operation = $this->createOperation();
        
        $operation->setOrder($order);
        if(!is_null($customer) && $customer instanceof CustomerRequestDTOV2) {
            $operation->setCustomer($customer);
        }

        return $this->client->prepareRequest('POST', $operationName, $operation, 'get-pre-order-info', [], true, false);
    }

    /**
     * Выполняет вызов стандартной операции Website.CreateOrder:
     *
     * @see https://developers.mindbox.ru/docs/xml
     *
     * @param OrderCreateRequestDTO $order         Объект, содержащий данные корзины для запроса.
     * @param string                $operationName Название операции.
     *
     * @return \Mindbox\Clients\AbstractMindboxClient
     */
    public function createOrder(OrderCreateRequestDTO $order, $operationName)
    {
        $this->client->setResponseType(MindboxOrderResponse::class);

        return $this->client->prepareRequest('POST', $operationName, $order, 'create', [], true, false);
    }

    /**
     * Выполняет вызов стандартной операции Website.ConfirmOrder:
     *
     * @see https://developers.mindbox.ru/docs/изменение-заказа
     *
     * @param OrderUpdateRequestDTO $order         Объект, содержащий данные корзины для запроса.
     * @param string                $operationName Название операции.
     *
     * @return \Mindbox\Clients\AbstractMindboxClient
     */
    public function confirmOrder(OrderUpdateRequestDTO $order, $operationName)
    {
        return $this->client->prepareRequest('POST', $operationName, $order, 'update-order', [], true, false);
    }

    /**
     * Выполняет вызов стандартной операции Website.CancelOrder:
     *
     * @see https://developers.mindbox.ru/docs/изменение-заказа
     *
     * @param OrderUpdateRequestDTO $order         Объект, содержащий данные корзины для запроса.
     * @param string                $operationName Название операции.
     *
     * @return \Mindbox\Clients\AbstractMindboxClient
     */
    public function cancelOrder(OrderUpdateRequestDTO $order, $operationName)
    {
        return $this->client->prepareRequest('POST', $operationName, $order, 'update-order', [], true, false);
    }

    /**
     * Выполняет вызов стандартной операции Website.OfflineOrder:
     *
     * @see https://developers.mindbox.ru/docs/изменение-заказа
     *
     * @param OrderUpdateRequestDTO $order         Объект, содержащий данные корзины для запроса.
     * @param string                $operationName Название операции.
     *
     * @return \Mindbox\Clients\AbstractMindboxClient
     */
    public function offlineOrder(OrderUpdateRequestDTO $order, $operationName)
    {
        return $this->client->prepareRequest('POST', $operationName, $order, 'update-order', [], true, false);
    }

    /**
     * Выполняет вызов стандартной операции Website.GetCustomerOrders:
     *
     * @see https://developers.mindbox.ru/docs/получение-списка-заказов-потребителя
     *
     * @param int    $countToReturn Максимальное количество заказов для возврата.
     * @param string $mindbox       Идентификатор потребителя.
     * @param int    $startingIndex Порядковый номер заказа, начиная с которого будет сформирован список заказов.
     * @param string $operationName Название операции.
     *
     * @return \Mindbox\Clients\AbstractMindboxClient
     */
    public function getOrders(
        CustomerRequestDTO $customer,
        $countToReturn,
        $pageNumber,
        $operationName,
        $addDeviceUUID = true
    ) {

        $operation = $this->createOperation();
        $operation->setCustomer($customer);
        $operation->setPage([
            'itemsPerPage' => $countToReturn,
            'pageNumber' => $pageNumber,
        ]);

        $this->client->setResponseType(MindboxOrdersResponse::class);

        return $this->client->prepareRequest('POST', $operationName, $operation, '', [], true, $addDeviceUUID);
    }

    
    public function getOrder(
        OrderRequestDTO $order,
        $operationName,
        $addDeviceUUID = true
    ) {

        $operation = $this->createOperation();
        $operation->setOrder($order);

        $this->client->setResponseType(MindboxOrdersResponse::class);

        return $this->client->prepareRequest('POST', $operationName, $operation, '', [], true, $addDeviceUUID);
    }

    public function beginOrderTransaction(
        OrderRequestDTO $order,
        CustomerRequestDTO $customer,
        $operationName,
        $addDeviceUUID = true
    )
    {
        $operation = $this->createOperation();
        $operation->setOrder($order);
        $operation->setCustomer($customer);

        $this->client->setResponseType(MindboxOrdersResponse::class);

        return $this->client->prepareRequest('POST', $operationName, $operation, '', [], true, $addDeviceUUID);
    }

    public function commitTransaction(OrderRequestDTO $order, $addDeviceUUID = true)
    {
        $operation = $this->createOperation();
        $operation->setOrder($order);

        $this->client->setResponseType(MindboxOrdersResponse::class);

        return $this->client->prepareRequest('POST', 'Website.CommitOrderTransaction', $operation, 'create', [], true, $addDeviceUUID);
    }

    public function rollbackTransaction(OrderRequestDTO $order, $addDeviceUUID = true)
    {
        $operation = $this->createOperation();
        $operation->setOrder($order);

        $this->client->setResponseType(MindboxOrderResponse::class);

        return $this->client->prepareRequest('POST', 'Website.RollbackOrderTransaction', $operation, 'create', [], false, $addDeviceUUID);
    }
}
