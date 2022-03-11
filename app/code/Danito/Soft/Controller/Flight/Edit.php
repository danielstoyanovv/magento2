<?php

declare(ticks=1);

namespace Danito\Soft\Controller\Flight;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Danito\Soft\Laravel\Api\Helper;

class Edit extends Action
{
    /**
     * @var Helper
     */
    private $helper;
    
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        Helper $helper
    ) {
        $this->_pageFactory = $pageFactory;
        $this->helper = $helper;
        return parent::__construct($context);
    }

    public function execute()
    {  
        $page =  $this->_pageFactory->create();
        if (!empty($this->_request->get('id'))) {
            $flight = $this->helper->getFlight($this->_request->get('id'));
            if (!empty($flight['error'])) {
                return $this->_redirect('danitosoft/flight/index');
            }
            if ($flight) {
                $page->getLayout()->getBlock('danito_soft_flight_edit')->setData('flight', $flight);
            }
        }
        return $page;
    }
}