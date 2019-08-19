<?php

namespace Werp\Builders\Modals;

use Werp\Builders\BaseBuilder;
use Werp\Builders\Inputs\InputBuilder;

class NewModal
{
    use BaseBuilder;

    protected $endpoint;
    protected $inputs;
    protected $title;

    /**
     * NewModal constructor.
     * @param $endpoint
     * @param $title
     * @param $icon
     */
    public function __construct($endpoint = null, $title = null, $inputs = [])
    {
        $this->endpoint = $endpoint;
        $this->title = $title;
        $this->inputs = $inputs;
    }

    /**
     * @return mixed
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @param mixed $endpoint
     * @return string
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return string
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function getInputs()
    {
        return $this->inputs;
    }

    public function setInputs($inputs)
    {
        $this->inputs = $this->to_collection($inputs);

        return $this;
    }

    public function addInput(InputBuilder $input)
    {
        $this->inputs = $this->to_collection($this->inputs);
        $this->inputs->push($input);
        return $this;
    }
}