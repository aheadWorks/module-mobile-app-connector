<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Controller\Payment;

use Aheadworks\MobileAppConnector\Model\Service\Encryption;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\Result\JsonFactory as JsonResultFactory;
use Aheadworks\MobileAppConnector\Model\Payment\Cart\Authorization as CartAuth;
use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultInterface;

/**
 * Class Index - loading payment page
 */
class Index extends Action
{
    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    /**
     * @var Encryption
     */
    private $encryption;

    /**
     * @var JsonResultFactory
     */
    private $jsonResultFactory;

    /**
     * @var CartAuth
     */
    private $cartAuth;

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param Encryption $encryption
     * @param JsonResultFactory $jsonResultFactory
     * @param CartAuth $cartAuth
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Encryption $encryption,
        JsonResultFactory $jsonResultFactory,
        CartAuth $cartAuth
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->encryption = $encryption;
        $this->jsonResultFactory = $jsonResultFactory;
        $this->cartAuth = $cartAuth;
        parent::__construct($context);
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface|\Magento\Framework\Controller\Result\Json
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function dispatch(RequestInterface $request)
    {
        $cartIdHash = (string)$request->getParam('id');

        $cartId = (int)$this->encryption->decryptUrlParam($cartIdHash);
        if (!$cartId) {
            return $this->jsonResultFactory->create()->setData(['exception' => __('Link is not correct!')]);
        }

        try {
            /** @var \Magento\Quote\Model\Quote $quote */
            $quote = $this->cartAuth->loadQuote($cartId);
            $this->cartAuth->authorizeCustomer($quote);
            $this->cartAuth->initializeCheckoutSession($quote);
        } catch (NoSuchEntityException | LocalizedException $ex) {
            return $this->jsonResultFactory->create()->setData(['exception' => $ex->getMessage()]);
        }

        return parent::dispatch($request);
    }

    /**
     * @inheritDoc
     */
    public function execute(): ResultInterface
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->addHandle('checkout_index_index');
        return $resultPage;
    }
}
