<?php

namespace Aheadworks\MobileAppConnector\Block\ThirdParty\Buildify\Page;

use \Aheadworks\MobileAppConnector\ViewModel\ThirdParty\Buildify\Page\Preview as ViewModel;
use Magento\Framework\View\Element\Template;

/**
 * Class for Preview
 */
class Preview extends Template
{
    /**
     * @var ViewModel
     */
    private $viewModel;

    /**
     * @param Template\Context $context
     * @param ViewModel $viewModel
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        ViewModel $viewModel,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->viewModel = $viewModel;
    }

    /**
     * Retrieve view model
     *
     * @return ViewModel
     */
    public function getViewModel()
    {
        return $this->viewModel;
    }
}
