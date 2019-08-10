<?php

namespace Werp\Builders\Inputs;

class AddressInput extends TextInput
{
    protected $addressName1;
    protected $addressName2;
    protected $addressValue1;
    protected $addressValue2;

    /**
     * InputBuilder constructor.
     * @param $name
     * @param $type
     * @param $icon
     * @param $text
     * @param $value
     */
    public function __construct($value = null, $disabled = false, $icon = null)
    {
        $this->name = 'address';
        $this->type = 'address';
        $this->icon = $icon;
        $this->text = trans('view.address');
        $this->value = $value;
        $this->disabled = $disabled;

        $this->addressName1 = 'address_1';
        $this->addressName2 = 'address_2';
    }

    public function setValue($value)
    {
        $this->addressValue1 = isset($value['address_1']) ? $value['address_1'] : null;
        $this->addressValue2 = isset($value['address_2']) ? $value['address_2'] : null;
    }

    /**
     * @return mixed
     */
    public function getAddressName1()
    {
        return $this->addressName1;
    }

    /**
     * @param mixed $addressName1
     * @return InputBuilder
     */
    public function setAddressName1($addressName1)
    {
        $this->addressName1 = $addressName1;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddressName2()
    {
        return $this->addressName2;
    }

    /**
     * @param mixed $addressName2
     * @return InputBuilder
     */
    public function setAddressName2($addressName2)
    {
        $this->addressName2 = $addressName2;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddressValue1()
    {
        return $this->addressValue1;
    }

    /**
     * @param mixed $addressValue1
     * @return InputBuilder
     */
    public function setAddressValue1($addressValue1)
    {
        $this->addressValue1 = $addressValue1;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddressValue2()
    {
        return $this->addressValue2;
    }

    /**
     * @param mixed $addressValue2
     * @return InputBuilder
     */
    public function setAddressValue2($addressValue2)
    {
        $this->addressValue2 = $addressValue2;
        return $this;
    }

}