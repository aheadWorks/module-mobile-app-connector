<?php
namespace Aheadworks\MobileAppConnector\Controller\Download;

use Magento\Authorization\Model\UserContextInterface;
use Magento\Downloadable\Controller\Download as DownloadController;
use Magento\Downloadable\Model\Link\Purchased\Item as PurchasedLinkItemModel;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Exception\AuthorizationException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Serialize\Serializer\Json as JsonSerializer;
use Magento\Webapi\Model\Authorization\TokenUserContext;
use Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased\Item\Provider
    as DownloadablePurchasedLinkItemProvider;
use Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased\Item\Validator
    as DownloadablePurchasedLinkItemValidator;
use Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased\Item\Resolver
    as DownloadablePurchasedLinkItemResolver;
use Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased\Item\Processor
    as DownloadablePurchasedLinkItemProcessor;

/**
 * Class for Link
 */
class Link extends DownloadController
{
    /**
     * @var DownloadablePurchasedLinkItemProvider
     */
    private $downloadablePurchasedLinkItemProvider;

    /**
     * @var DownloadablePurchasedLinkItemValidator
     */
    private $downloadablePurchasedLinkItemValidator;

    /**
     * @var DownloadablePurchasedLinkItemResolver
     */
    private $downloadablePurchasedLinkItemResolver;

    /**
     * @var DownloadablePurchasedLinkItemProcessor
     */
    private $downloadablePurchasedLinkItemProcessor;

    /**
     * @var TokenUserContext
     */
    private $tokenUserContext;

    /**
     * @var JsonSerializer
     */
    private $jsonSerializer;

    /**
     * @param Context $context
     * @param DownloadablePurchasedLinkItemProvider $downloadablePurchasedLinkItemProvider
     * @param DownloadablePurchasedLinkItemValidator $downloadablePurchasedLinkItemValidator
     * @param DownloadablePurchasedLinkItemResolver $downloadablePurchasedLinkItemResolver
     * @param DownloadablePurchasedLinkItemProcessor $downloadablePurchasedLinkItemProcessor
     * @param TokenUserContext $tokenUserContext
     * @param JsonSerializer $jsonSerializer
     */
    public function __construct(
        Context $context,
        DownloadablePurchasedLinkItemProvider $downloadablePurchasedLinkItemProvider,
        DownloadablePurchasedLinkItemValidator $downloadablePurchasedLinkItemValidator,
        DownloadablePurchasedLinkItemResolver $downloadablePurchasedLinkItemResolver,
        DownloadablePurchasedLinkItemProcessor $downloadablePurchasedLinkItemProcessor,
        TokenUserContext $tokenUserContext,
        JsonSerializer $jsonSerializer
    ) {
        parent::__construct($context);
        $this->downloadablePurchasedLinkItemProvider = $downloadablePurchasedLinkItemProvider;
        $this->downloadablePurchasedLinkItemValidator = $downloadablePurchasedLinkItemValidator;
        $this->downloadablePurchasedLinkItemResolver = $downloadablePurchasedLinkItemResolver;
        $this->downloadablePurchasedLinkItemProcessor = $downloadablePurchasedLinkItemProcessor;
        $this->tokenUserContext = $tokenUserContext;
        $this->jsonSerializer = $jsonSerializer;
    }

    /**
     * Download link action
     *
     * @return void|ResponseInterface
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function execute()
    {
        $userType = $this->tokenUserContext->getUserType();
        if ($userType == UserContextInterface::USER_TYPE_CUSTOMER) {
            $customerId = $this->tokenUserContext->getUserId();
            $downloadablePurchasedLinkItem = $this->getDownloadablePurchasedLinkItem();

            try {
                $this->downloadablePurchasedLinkItemValidator->validateForDownloading(
                    $downloadablePurchasedLinkItem,
                    $customerId
                );

                $resourceFilePath = $this->downloadablePurchasedLinkItemResolver->getResourceFilePath(
                    $downloadablePurchasedLinkItem
                );
                $resourceType = $downloadablePurchasedLinkItem->getLinkType();

                $this->_processDownload($resourceFilePath, $resourceType);

                $this->downloadablePurchasedLinkItemProcessor->postprocessDownloading(
                    $downloadablePurchasedLinkItem
                );
                // phpcs:ignore Magento2.Security.LanguageConstruct.ExitUsage
                exit(0);
            } catch (AuthorizationException $exception) {
                return $this->setResponseMessage(
                    __("Please, specify valid customer access token")->render()
                );
            } catch (LocalizedException $exception) {
                return $this->setResponseMessage(
                    $exception->getMessage()
                );
            } catch (\Exception $exception) {
                return $this->setResponseMessage(
                    __("Something went wrong while getting the requested content.")->render()
                );
            }
        }

        return $this->setResponseMessage(
            __("Please, specify valid customer access token")->render()
        );
    }

    /**
     * Set information message in JSON format for the response
     *
     * @param string $message
     * @return ResponseInterface
     */
    private function setResponseMessage($message)
    {
        $this->getResponse()->representJson(
            $this->jsonSerializer->serialize(['message' => $message])
        );
        return $this->getResponse();
    }

    /**
     * Retrieve current purchased link item
     *
     * @return PurchasedLinkItemModel
     */
    private function getDownloadablePurchasedLinkItem()
    {
        $linkItemHash = $this->getRequest()->getParam('id', 0);

        return $this->downloadablePurchasedLinkItemProvider->getByLinkHash(
            $linkItemHash
        );
    }
}
