<?php

declare(ticks=1);

namespace Danito\Soft\Controller\Flight;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Danito\Soft\Laravel\Api\Helper;

class Create extends Action
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
        if ($this->_request->isPost()) {
            $response = $this->helper->createFlight($this->_request);
            if (!empty($response['id'])) {
                $this->messageManager->addSuccess(__('Flight is created!'));
            }
        }
        return $this->_pageFactory->create();
	}
}