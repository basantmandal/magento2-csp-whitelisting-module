<?php

namespace HK2\CspWhitelisting\Controller\Adminhtml\Reset;

use Magento\Backend\App\Action;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class ResetConfig extends Action
{
    /**
     * @var WriterInterface
     */
    protected WriterInterface $configWriter;

    /**
     * @var StoreManagerInterface
     */
    protected StoreManagerInterface $storeManager;

    /**
     * @var array|string[]
     */
    protected array $fields = [
        'script_src',
        'style_src',
        'img_src',
        'connect_src',
        'font_src',
        'frame_src',
    ];

    /**
     * @param Action\Context        $context
     * @param WriterInterface       $configWriter
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Action\Context $context,
        WriterInterface $configWriter,
        StoreManagerInterface $storeManager
    ) {
        parent::__construct($context);
        $this->configWriter = $configWriter;
        $this->storeManager = $storeManager;
    }

    /**
     * Resets CSP configuration for default, website and store scopes.
     *
     * @return ResultInterface|ResponseInterface|Redirect
     */
    public function execute(): ResultInterface|ResponseInterface|Redirect
    {
        $basePath =
            'hk2_cspWhitelisting_section1/hk2_cspwhitelisting_section1_group2/';

        foreach ($this->fields as $field) {
            $this->configWriter->delete($basePath . $field);
        }

        // Website scope
        foreach ($this->storeManager->getWebsites() as $website) {
            foreach ($this->fields as $field) {
                $this->configWriter->delete(
                    $basePath . $field,
                    ScopeInterface::SCOPE_WEBSITES,
                    $website->getId()
                );
            }
        }

        // Store scope
        foreach ($this->storeManager->getStores() as $store) {
            foreach ($this->fields as $field) {
                $this->configWriter->delete(
                    $basePath . $field,
                    ScopeInterface::SCOPE_STORES,
                    $store->getId()
                );
            }
        }

        $this->messageManager->addSuccessMessage(
            __('CSP configuration has been reset.')
        );

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath(
            'adminhtml/system_config/edit',
            ['section' => 'hk2_cspWhitelisting_section1']
        );
    }

    /**
     * Check if the user is allowed to access the CSP configuration reset page.
     *
     * @return bool
     */
    protected function _isAllowed(): bool
    {
        return $this->_authorization->isAllowed(
            'HK2_CspWhitelisting::core_config'
        );
    }
}
