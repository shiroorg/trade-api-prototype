<?php

namespace Trade\Api;

use http\Exception;

class AbstractRequest implements InterfaceGetError, InterfaceInfo, InterfaceOrders, InterfaceAccount, InterfaceOrderCreate, InterfaceOrderStatus, InterfaceMyOrders
{

    /**
     * @var array
     */
    private array $arParams = array();

    /**
     * @var array
     */
    private array $arError = array();

    /**
     * @param array $params
     */
    public function __construct(array $params = array())
    {
        $this->arParams = $params;
    }

    /**
     * @param array $req
     * @return mixed
     * @throws \Exception
     */
    private function Request(array $req = array())
    {
        $msec = round(microtime(true) * 1000);
        $req['post']['ts'] = $msec;

        $post = json_encode($req['post']);

        $sign = hash_hmac('sha256', $req['method'] . $post, $this->arParams['key']);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://payeer.com/api/trade/" . $req['method']);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "API-ID: " . $this->arParams['id'],
            "API-SIGN: " . $sign
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        $arResponse = json_decode($response, true);

        if ($arResponse['success'] !== true) {
            $this->arError = $arResponse['error'];
            throw new \Exception($arResponse['error']['code']);
        }

        return $arResponse;
    }

    /**
     * @return array
     */
    public function GetError(): array
    {
        return $this->arError;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function Info(): array
    {
        $res = $this->Request(array(
            'method' => 'info',
        ));

        return $res;
    }

    /**
     * @param string $pair
     * @return mixed
     * @throws \Exception
     */
    public function Orders(string $pair = 'BTC_USDT'): array
    {
        $res = $this->Request(array(
            'method' => 'orders',
            'post' => array(
                'pair' => $pair,
            ),
        ));

        return $res['pairs'];
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function Account(): array
    {
        $res = $this->Request(array(
            'method' => 'account',
        ));

        return $res['balances'];
    }

    /**
     * @param array $req
     * @return mixed
     * @throws \Exception
     */
    public function OrderCreate(array $req = array()): array
    {
        $res = $this->Request(array(
            'method' => 'order_create',
            'post' => $req,
        ));

        return $res;
    }

    /**
     * @param array $req
     * @return mixed
     * @throws \Exception
     */
    public function OrderStatus(array $req = array()): array
    {
        $res = $this->Request(array(
            'method' => 'order_status',
            'post' => $req,
        ));

        return $res['order'];
    }

    /**
     * @param array $req
     * @return mixed
     * @throws \Exception
     */
    public function MyOrders(array $req = array()): array
    {
        $res = $this->Request(array(
            'method' => 'my_orders',
            'post' => $req,
        ));

        return $res['items'];
    }
}
