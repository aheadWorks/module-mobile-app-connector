<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Model\Payment;

use Magento\Customer\Model\Session as CustomerSession;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;

/**
 * Class CustomerManagement to manage customer session
 */
class CustomerManagement
{
    /**
     * @var CustomerSession
     */
    private $customerSession;

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * CustomerManagement constructor.
     *
     * @param CustomerSession $customerSession
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        CustomerSession $customerSession,
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->customerSession = $customerSession;
        $this->customerRepository = $customerRepository;
    }

    /**
     * Is customer logged in
     *
     * @param CustomerInterface $customer
     * @return bool
     */
    public function isCustomerLoggedIn(CustomerInterface $customer): bool
    {
        $authorizedCustomer = $this->customerSession->getCustomer();
        return $this->customerSession->isLoggedIn() && $customer->getEmail() === $authorizedCustomer->getEmail() &&
            (int)$customer->getId() === (int)$authorizedCustomer->getId() &&
            (int)$customer->getWebsiteId() === (int)$authorizedCustomer->getWebsiteId();
    }

    /**
     * Authorize customer
     *
     * @param string $email
     * @param string $websiteId
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @return void
     */
    public function authorizeCustomer(string $email, string $websiteId): void
    {
        $customer = $this->customerRepository->get($email, $websiteId);
        $this->customerSession->setCustomerDataAsLoggedIn($customer);
    }

    /**
     * Logout customer from session
     *
     * @return void
     */
    public function logoutCustomer(): void
    {
        $this->customerSession->logout();
    }
}
