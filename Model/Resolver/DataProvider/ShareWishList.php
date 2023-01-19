<?php

namespace Aheadworks\MobileAppConnector\Model\Resolver\DataProvider;

use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Contact\Model\ConfigInterface;
use Magento\Contact\Model\MailInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\DataObject;
use Magento\Customer\Model\Customer;
use Magento\Framework\App\Action;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Escaper;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\Session\Generic as WishlistSession;
use Magento\Framework\View\Result\Layout as ResultLayout;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Wishlist\Block\Share\Email\Items;
use Magento\Customer\Helper\View;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Wishlist\Model\Config;
use Magento\Customer\Model\Session;
use Magento\Wishlist\Controller\WishlistProviderInterface;
use Magento\Framework\Validator\EmailAddress;

/**
 * Class for ShareWishList
 */
class ShareWishList
{
    /**
     * @var Escaper
     */
    private $escaper;

    /**
     * @var \Magento\Customer\Helper\View
     */
    protected $_customerHelperView;

    /**
     * @var StateInterface
     */
    protected $inlineTranslation;

    /**
     * @var TransportBuilder
     */
    protected $_transportBuilder;

    /**
     * @var Config
     */
    protected $_wishlistConfig;

    /**
     * @var WishlistProviderInterface
     */
    protected $wishlistProvider;

    /**
     * @var Session
     */
    protected $_customerSession;

    /**
     * @var WishlistSession
     */
    protected $wishlistSession;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var MailInterface
     */
    private $mail;

    /**
     * @var Items
     */
    private $items;

    /**
     * @var EmailAddress
     */
    private $emailValidator;

    /**
     * @param Context $context
     * @param ConfigInterface $contactsConfig
     * @param MailInterface $mail
     * @param Session $customerSession
     * @param WishlistProviderInterface $wishlistProvider
     * @param Config $wishlistConfig
     * @param TransportBuilder $transportBuilder
     * @param StateInterface $inlineTranslation
     * @param View $customerHelperView
     * @param WishlistSession $wishlistSession
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     * @param ResultFactory $resultFactory
     * @param Escaper|null $escaper
     * @param Items $items
     * @param EmailAddress $emailValidator
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        Context $context,
        ConfigInterface $contactsConfig,
        MailInterface $mail,
        Session $customerSession,
        WishlistProviderInterface $wishlistProvider,
        Config $wishlistConfig,
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation,
        View $customerHelperView,
        WishlistSession $wishlistSession,
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        ResultFactory $resultFactory,
        Escaper $escaper = null,
        Items $items,
        EmailAddress $emailValidator
    ) {
        $this->mail = $mail;
        $this->_customerSession = $customerSession;
        $this->wishlistProvider = $wishlistProvider;
        $this->_wishlistConfig = $wishlistConfig;
        $this->_transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->_customerHelperView = $customerHelperView;
        $this->wishlistSession = $wishlistSession;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->escaper = $escaper ?? ObjectManager::getInstance()->get(
            Escaper::class
        );
        $this->resultFactory = $resultFactory;
        $this->_items = $items;
        $this->emailValidator = $emailValidator;
    }

    /**
     * Share wishlist
     *
     * @param String $emails
     * @param String $message
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function shareWishList($emails, $message)
    {

        $thanksMessage = [];

        /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        
        $wishlist = $this->wishlistProvider->getWishlist();
        if (!$wishlist) {
            throw new NotFoundException(__('Page not found.'));
        }

        $sharingLimit = $this->_wishlistConfig->getSharingEmailLimit();
        $textLimit = $this->_wishlistConfig->getSharingTextLimit();
        $emailsLeft = $sharingLimit - $wishlist->getShared();

        $emails = empty($emails) ? $emails : explode(',', $emails);

        $error = false;
        $message = (string)$message;
        if (strlen($message) > $textLimit) {
            $error = __('Message length must not exceed %1 symbols', $textLimit);
        } else {
            $message = nl2br((string)$this->escaper->escapeHtml($message));
            if (empty($emails)) {
                $error = __('Please enter an email address.');
            } else {
                if (count($emails) > $emailsLeft) {
                    $error = __('Maximum of %1 emails can be sent.', $emailsLeft);
                } else {
                    foreach ($emails as $index => $email) {
                        $email = $email !== null ? trim($email) : '';
                        if (!$this->emailValidator->isValid($email)) {
                            $error = __('Please enter a valid email address.');
                            break;
                        }
                        $emails[$index] = $email;
                    }
                }
            }
        }

        if ($error) {
            $thanksMessage['success_message'] = $error;
            return $thanksMessage;
        }
        /** @var \Magento\Framework\View\Result\Layout $resultLayout */
        $resultLayout = $this->resultFactory->create(ResultFactory::TYPE_LAYOUT);
        $this->addLayoutHandles($resultLayout);
        $this->inlineTranslation->suspend();

        $sent = 0;

        try {
            $customer = $this->_customerSession->getCustomerDataObject();
            $customerName = $this->_customerHelperView->getCustomerName($customer);
            if (!empty($customerName) && $customerName != " ") {
                $emails = array_unique($emails);
                $sharingCode = $wishlist->getSharingCode();
                try {
                    foreach ($emails as $email) {
                        $transport = $this->_transportBuilder->setTemplateIdentifier(
                            $this->scopeConfig->getValue(
                                'wishlist/email/email_template',
                                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                            )
                        )->setTemplateOptions(
                            [
                                'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                                'store' => $this->storeManager->getStore()->getStoreId(),
                            ]
                        )->setTemplateVars(
                            [
                                'customer' => $customer,
                                'customerName' => $customerName,
                                'salable' => $wishlist->isSalable() ? 'yes' : '',
                                'items' => $this->getWishlistItems($resultLayout),
                                'viewOnSiteLink' =>  $this->storeManager->getStore()->getBaseUrl().
                                'wishlist/shared/index/code/'.$sharingCode,
                                'message' => $message,
                                'store' => $this->storeManager->getStore(),
                            ]
                        )->setFrom(
                            $this->scopeConfig->getValue(
                                'wishlist/email/email_identity',
                                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                            )
                        )->addTo(
                            $email
                        )->getTransport();

                        $transport->sendMessage();

                        $sent++;
                    }
                } catch (\Exception $e) {
                    $wishlist->setShared($wishlist->getShared() + $sent);
                    $wishlist->save();
                    $thanksMessage['success_message'] = $e;
                    return $thanksMessage;
                }
            } else {
                 $thanksMessage['success_message'] = "Please Login.";
                return $thanksMessage;
            }
            $wishlist->setShared($wishlist->getShared() + $sent);
            $wishlist->save();

            $this->inlineTranslation->resume();
            $thanksMessage['success_message'] = "Your wish list has been shared.";
            return $thanksMessage;
        } catch (\Exception $e) {
            $this->inlineTranslation->resume();
            $thanksMessage['success_message'] = $e;
            return $thanksMessage;

        }
    }

    /**
     * Prepare to load additional email blocks
     *
     * Add 'wishlist_email_rss' layout handle.
     * Add 'wishlist_email_items' layout handle.
     *
     * @param \Magento\Framework\View\Result\Layout $resultLayout
     * @return void
     */
    protected function addLayoutHandles(ResultLayout $resultLayout)
    {
        $resultLayout->addHandle('wishlist_email_items');
    }

    /**
     * Retrieve RSS link content (html)
     *
     * @param int $wishlistId
     * @param \Magento\Framework\View\Result\Layout $resultLayout
     */
    protected function getRssLink($wishlistId, ResultLayout $resultLayout)
    {
        if (isset($POST['rss_url'])) {
            if ($POST['rss_url']) {
                return $resultLayout->getLayout()
                    ->getBlock('wishlist.email.rss')
                    ->setWishlistId($wishlistId)
                    ->toHtml();
            }
        }
    }

    /**
     * Retrieve wishlist items content (html)
     *
     * @param \Magento\Framework\View\Result\Layout $resultLayout
     * @return string
     */
    protected function getWishlistItems(ResultLayout $resultLayout)
    {
        $wishlistitems = $this->_items;
        $mediaUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $countWhishListItem = $wishlistitems->getWishlistItemsCount();
        $emailitems = [];
        $itemsdetails =  $i = 0;
        foreach ($wishlistitems->getWishlistItems() as $item) {
            $i++;
            $_product = $item->getProduct();
            $_product->getName();
            $wishlistitems->getProductUrl($item);
            $productThumbnail = $wishlistitems->getProductForThumbnail($item);
            $emailitems[] ='<div style="display: inline-block; margin-left: 8px;">
                            <table>
                                <tr><td class="col product">     
                                <p>
                                <a href="'. $wishlistitems->escapeUrl($wishlistitems->getProductUrl($item)) .'">
                                   <img width="135" height="135" src="'.$mediaUrl.
                                   'catalog/product/'.$_product->getData('small_image') .'"/>
                                </a>
                            </p>                                
                                <p>
                                <a href="'.$wishlistitems->escapeUrl($wishlistitems->getProductUrl($item)) .'">
                                    '. $_product->getName() .'
                                </a>
                            </p>
                            <p>
                                <a href="'. $wishlistitems->escapeUrl($wishlistitems->getProductUrl($item)) .'">
                                    '. $wishlistitems->escapeHtml(__('View Product')) .'
                                </a>
                            </p>
                            </td></tr>
                            </table>
                            </div>';
          
        }
        return implode(" ", $emailitems);
    }
}
