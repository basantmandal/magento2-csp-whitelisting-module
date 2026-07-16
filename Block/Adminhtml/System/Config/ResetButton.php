<?php

declare(strict_types=1);

namespace HK2\Csp\Block\Adminhtml\System\Config;

use Magento\Backend\Block\Widget\Button;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Exception\LocalizedException;

class ResetButton extends Field
{
    /**
     * @var string
     */
    protected $_template = 'HK2_Csp::system/config/reset_button.phtml';

    /**
     * Render the reset button.
     *
     * This method is overridden to reset the "Use Website" and "Use Default" values
     * for the field.
     *
     * @param AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element): string
    {
        $element->unsScope()
            ->unsCanUseWebsiteValue()
            ->unsCanUseDefaultValue();

        return parent::render($element);
    }

    /**
     * Sends the Reset URL
     *
     * @return string
     */
    public function getResetUrl(): string
    {
        return $this->getUrl('csp/reset/resetconfig');
    }

    /**
     * Gets the HTML for the reset button.
     *
     * @return mixed
     * @throws LocalizedException
     */
    public function getButtonHtml(): mixed
    {
        return $this->getLayout()
            ->createBlock(Button::class)
            ->setData([
                'id' => 'cspwhitelisting_reset_button',
                'label' => __('Reset CSP to Defaults'),
                'class' => 'primary'
            ])
            ->toHtml();
    }

    /**
     * Return the HTML for the element.
     *
     * This method is a part of the ElementInterface and is used to render the element in the form.
     *
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element): string
    {
        return $this->_toHtml();
    }
}
