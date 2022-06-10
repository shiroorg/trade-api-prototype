<?php

namespace Api;

class TradePayeer{

    /**
     * @var array
     */
    private $arParams = array();

    /**
     * @var array
     */
    private $arError = array();

    public function __construct($params = array())
    {
        $this->arParams = $params;
    }


}
