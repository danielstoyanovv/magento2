<?php

declare(ticks=1);

namespace Danito\Soft\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Danito\Soft\Laravel\Api\Helper;

class FlightsData implements ArgumentInterface
{
    /**
     * @var Helper
     */
    private $helper;

    public function __construct(
        Helper $helper
    ) {
        $this->helper = $helper;
    }

    /**
     * get flights
     * @return array
     */
    public function getFlights(): array
    {
        return $this->helper->getFlights();
    }
}