<?php
/**
 * A Magento 2 module named Aheadworks\MobileAppConnector
 *
 */
namespace Aheadworks\MobileAppConnector\Model;

use Aheadworks\MobileAppConnector\Api\RelatedProductsRepositoryInterface;
use Magento\Framework\Exception\InputException;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Aheadworks\MobileAppConnector\Model\Product\Image\Resolver;
use Magento\Catalog\Model\Product\LinkFactory;
use Magento\Catalog\Model\Product\Link;
use Magento\Catalog\Api\Data\ProductInterface;

/**
 * Class RelatedProductsManagement
 * @package Aheadworks\MobileAppConnector\Model
 */
class RelatedProductsManagement implements RelatedProductsRepositoryInterface
{
    
    /*
     * Entity Id.
     */
    const ENTITY_ID = 'entity_id';

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var Resolver
     */
    protected $imageResolver;

    /**
     * @var LinkFactory
     */
    private $linkFactory;


    /**
     * @param ProductRepositoryInterface $productRepository
     * @param Resolver $imageResolver
     * @param LinkFactory $linkFactory
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        Resolver $imageResolver,
        LinkFactory $linkFactory
    ) {
        $this->productRepository = $productRepository;
        $this->imageResolver = $imageResolver;
        $this->linkFactory = $linkFactory;
    }


    /**
     * @inheritdoc
     */
    public function getRelatedProducts($sku)
    {
        if (empty($sku) || !isset($sku) || $sku == "") {
            throw new InputException(__('Sku required'));
        }
        try {

            $product =  $this->productRepository->get($sku);
            $linkType = $this->getLinkType();
            $link = $this->linkFactory->create(['data' => ['link_type_id' => $linkType]]);
            $collection = $link->getProductCollection();
            $collection->setIsStrongMode();
            $collection->setProduct($product);
            $relatedProducts = $collection->getItems();
            $relatedProductsData = [];
        
            foreach ($relatedProducts as $relatedProduct) {
                $relatedProduct = $this->productRepository->get($relatedProduct->getSku());

                $data = [
                        self::ENTITY_ID => $relatedProduct->getEntityId(),
                        ProductInterface::SKU => $relatedProduct->getSku(),
                        ProductInterface::NAME => $relatedProduct->getName(),
                        ProductInterface::PRICE => $relatedProduct->getPrice(),
                        ProductInterface::MEDIA_GALLERY => $this->imageResolver->getProductImageUrl($relatedProduct, 'category_page_grid')

                ];
                $relatedProductsData []= $data;
            }
            return $relatedProductsData;
        }catch (\Exception $e) {
            throw new \Exception(__('We can\'t get Related product right now.'));
        }  
    }

    /**
     * @inheritDoc
     */
    protected function getLinkType(): int
    {
        return Link::LINK_TYPE_RELATED;
    }
}
