<?php
namespace Amasty\Xnotif\Controller\Category\Index;

/**
 * Interceptor class for @see \Amasty\Xnotif\Controller\Category\Index
 */
class Interceptor extends \Amasty\Xnotif\Controller\Category\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\ConfigurableProduct\Block\Product\View\Type\Configurable $configurableBlock, \Magento\Catalog\Api\ProductRepositoryInterface $productRepository, \Magento\CatalogInventory\Model\StockRegistry $stockRegistry, \Amasty\Xnotif\Helper\Data $helper, \Magento\Framework\Registry $registry, \Magento\Framework\Json\EncoderInterface $jsonEncoder, \Magento\Framework\View\LayoutInterface $layout, \Amasty\Xnotif\Plugins\Catalog\Block\Product\AbstractProduct $abstractProduct, \Magento\Framework\Url\Helper\Data $urlHelper, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory)
    {
        $this->___init();
        parent::__construct($context, $configurableBlock, $productRepository, $stockRegistry, $helper, $registry, $jsonEncoder, $layout, $abstractProduct, $urlHelper, $storeManager, $productCollectionFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        if (!$pluginInfo) {
            return parent::execute();
        } else {
            return $this->___callPlugins('execute', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(\Magento\Framework\App\RequestInterface $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'dispatch');
        if (!$pluginInfo) {
            return parent::dispatch($request);
        } else {
            return $this->___callPlugins('dispatch', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getActionFlag()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getActionFlag');
        if (!$pluginInfo) {
            return parent::getActionFlag();
        } else {
            return $this->___callPlugins('getActionFlag', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getRequest()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getRequest');
        if (!$pluginInfo) {
            return parent::getRequest();
        } else {
            return $this->___callPlugins('getRequest', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getResponse()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getResponse');
        if (!$pluginInfo) {
            return parent::getResponse();
        } else {
            return $this->___callPlugins('getResponse', func_get_args(), $pluginInfo);
        }
    }
}
