<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Controller\Payment;

use Aheadworks\MobileAppConnector\Model\Payment\CheckoutInitializer;
use Aheadworks\MobileAppConnector\Model\Payment\QuoteManagement;
use Aheadworks\MobileAppConnector\Model\Service\Encryption;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\Result\JsonFactory as JsonResultFactory;
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
     * @var QuoteManagement
     */
    private $quoteManagement;

    /**
     * @var CheckoutInitializer
     */
    private $checkoutInitializer;

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param Encryption $encryption
     * @param JsonResultFactory $jsonResultFactory
     * @param QuoteManagement $quoteManagement
     * @param CheckoutInitializer $checkoutInitializer
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Encryption $encryption,
        JsonResultFactory $jsonResultFactory,
        QuoteManagement $quoteManagement,
        CheckoutInitializer $checkoutInitializer
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->encryption = $encryption;
        $this->jsonResultFactory = $jsonResultFactory;
        $this->quoteManagement = $quoteManagement;
        $this->checkoutInitializer = $checkoutInitializer;
        parent::__construct($context);
    }

    /**
     * Dispatch request (payment page initialization)
     *
     * @param RequestInterface $request
     * @return ResponseInterface|\Magento\Framework\Controller\Result\Json
     * @throws \Magento\Framework\Exception\NotFoundException
     * @throws LocalizedException
     */
    public function dispatch(RequestInterface $request)
    {
        $cartIdHash = (string)$request->getParam('id');

        try {
            $cartId = (int)$this->encryption->decryptUrlParam($cartIdHash);
            if (!$cartId) {
                return $this->jsonResultFactory->create()->setData(['exception' => __('Link is not correct!')]);
            }

            $quote = $this->quoteManagement->loadQuoteByCartId($cartId);
            $this->quoteManagement->validateQuote($quote);

            $this->checkoutInitializer->initializeCustomerSession($quote);
            $this->checkoutInitializer->initializeCheckoutSession($quote);
        } catch (NoSuchEntityException | LocalizedException $ex) {
            return $this->jsonResultFactory->create()->setData(['exception' => $ex->getMessage()]);
        }

        return parent::dispatch($request);
    }

    /**
     * Payment index action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute(): ResultInterface
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->addHandle('checkout_index_index');
        return $resultPage;
    }
}
