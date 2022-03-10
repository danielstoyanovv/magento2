<?php

declare(ticks=1);

namespace Danito\Soft\Controller\Flight;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    public function __construct(
		Context $context,
		PageFactory $pageFactory
    ) {
		$this->_pageFactory = $pageFactory;
		return parent::__construct($context);
	}

	public function execute()
	{  
        return $this->_pageFactory->create();
	}
}