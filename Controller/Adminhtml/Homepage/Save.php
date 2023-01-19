<?php
namespace Aheadworks\MobileAppConnector\Controller\Adminhtml\Homepage;

use Aheadworks\MobileAppConnector\Api\HomepageRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class for Save
 */
class Save extends Action
{
    /**
     * @var HomepageRepositoryInterface
     */
    private $homepageRepository;

    /**
     * @var DataProcessor
     */
    private $dataProcessor;

    /**
     * @param Action\Context $context
     * @param HomepageRepositoryInterface $homepageRepository
     * @param DataProcessor $dataProcessor
     */
    public function __construct(
        Action\Context $context,
        HomepageRepositoryInterface $homepageRepository,
        DataProcessor $dataProcessor
    ) {
        parent::__construct($context);
        $this->homepageRepository = $homepageRepository;
        $this->dataProcessor = $dataProcessor;
    }

    /**
     * Homepage save action
     *
     * @return string
     */
    public function execute()
    {
        $requestData = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($requestData) {
            try {
                $homepage = $this->dataProcessor->prepareHomepage($this->getRequest());

                $this->homepageRepository->save($homepage);
                $this->messageManager->addSuccessMessage(__('The homepage was successfully saved.'));
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $exception) {
                $this->messageManager->addExceptionMessage(
                    $exception,
                    __('Something went wrong while saving the homepage.')
                );
            }
        }

        return $resultRedirect->setPath('*/*/');
    }
}
