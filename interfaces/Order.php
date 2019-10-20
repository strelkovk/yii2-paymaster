<?php
namespace strelkovk\paymaster\interfaces;

interface Order
{
    public function getId();

    public function getCost();

    public function setPaymentStatus($status);
}
