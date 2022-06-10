<?php

namespace Trade\Api;

class Payeer implements \InterfaceAccount {

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

    public function Account()
    {
        // TODO: Implement Account() method.
    }

}
