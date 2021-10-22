<?php

namespace Packetery\Order;

use Packetery\Weight\Converter;

class Ajax
{
    /** @var OrderRepository */
    private $orderRepository;
    /** @var \Packetery */
    private $module;

    /**
     * Ajax constructor.
     * @param \Packetery $module
     * @param OrderRepository $orderRepository
     */
    public function __construct(\Packetery $module, OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->module = $module;
    }

    /**
     * @return string JSON encoded result.
     */
    public function actionSetWeights()
    {
        $result = [];
        $orderWeights = (\Tools::getIsset('orderWeights') ? \Tools::getValue('orderWeights') : null);
        if (empty($orderWeights)) {
            $result['info'] = $this->module->l('No changes to weights.', 'ajax');
            return json_encode($result);
        }

        $storedWeights = $this->orderRepository->getWeights(array_keys($orderWeights));
        if($storedWeights) {
            $storedWeightsAssoc = array_combine(
                array_column($storedWeights, 'id_order'),
                array_column($storedWeights, 'weight')
            );
        } else {
            $storedWeightsAssoc = [];
        }

        $changeCounter = 0;
        foreach ($orderWeights as $orderId => $weight) {
            if ($weight === '') {
                $weight = null;
            } else {
                $weight = str_replace([',', ' '], ['.', ''], $weight);
            }
            if ($weight === null || is_numeric($weight)) {
                if ($weight === null) {
                    $order = new \Order($orderId);
                    $result[$orderId]['value'] = Converter::getKilograms($order->getTotalWeight());
                }
                if ($weight != $storedWeightsAssoc[$orderId]) {
                    $this->orderRepository->updateWeight($orderId, $weight);
                    $changeCounter++;
                    if ($weight !== null) {
                        $result[$orderId]['value'] = $weight;
                    }
                }
            } else {
                $result[$orderId]['error'] = $this->module->l('Please enter a number.', 'ajax');
            }
        }
        if ($changeCounter === 0) {
            $result['info'] = $this->module->l('No changes to weights.', 'ajax');
        }

        return json_encode($result);
    }

    /**
     * @return false|string JSON encoded boolean.
     */
    public function widgetSaveOrderAddress()
    {
        $cartId = \Context::getContext()->cart->id;

        if (!isset($cartId) || !\Tools::getIsset('address')) {
            return json_encode(false);
        }

        $address = \Tools::getValue('address');
        // todo 405 save carrierId, branchId, branchName, branchCurrency?
        $packeteryOrderFields = [
            'is_ad' => 1,
            'country' => $address['country'],
            'county' => $address['county'],
            'zip' => $address['postcode'],
            'city' => $address['city'],
            'street' => $address['street'],
            'house_number' => $address['houseNumber'],
            'latitude' => $address['latitude'],
            'longitude' => $address['longitude'],
        ];
        $db = \Db::getInstance();
        $isOrderSaved = (new OrderRepository($db))->existsByCart($cartId);
        if ($isOrderSaved) {
            $result = $db->update('packetery_order', $packeteryOrderFields, '`id_cart` = ' . ((int)$cartId));
        } else {
            $packeteryOrderFields['id_cart'] = ((int)$cartId);
            $result = $db->insert('packetery_order', $packeteryOrderFields);
        }

        return json_encode($result);
    }
}
