<?php

namespace Werp\Builders;


class ColBuilder
{
    use BaseBuilder;

    protected $id;
    protected $width;
    protected $cards;
    protected $forms;

    /**
     * TabBuilder constructor.
     * @param $id
     * @param $text
     */
    public function __construct($width = '', $id = null)
    {
        $this->id = $id;
        $this->width = $width;
        $this->cards = collect([]);
        $this->forms = collect([]);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return TabBuilder
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function width()
    {
        return $this->width;
    }

    /**
     * @param mixed $width
     * @return TabBuilder
     */
    public function setWidth($width)
    {
        $this->width = $width;
        return $this;
    }

    public function addCard(CardBuilder $card)
    {
        $this->cards = $this->to_collection($this->cards);
        $this->cards->push($card);
        return $this;
    }

    public function setCards($cards)
    {
        $this->cards = $this->to_collection($cards);
        return $this;
    }

    public function cards()
    {
        return $this->cards;
    }

    public function hasCards()
    {
        return $this->cards && $this->cards->isNotEmpty();
    }

    public function addForm(FormBuilder $form)
    {
        $this->forms = $this->to_collection($this->forms);
        $this->forms->push($form);
        return $this;
    }

    public function setForms($forms)
    {
        $this->forms = $this->to_collection($forms);
        return $this;
    }

    public function forms()
    {
        return $this->forms;
    }

    public function hasForms()
    {
        return $this->forms && $this->forms->isNotEmpty();
    }
}