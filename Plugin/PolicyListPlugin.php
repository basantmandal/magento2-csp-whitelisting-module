<?php

namespace HK2\CspWhitelisting\Plugin;

use Magento\Csp\Model\Policy\PolicyList;
use Magento\Framework\App\Config\ScopeConfigInterface;

class PolicyListPlugin
{
    public const string XML_PATH_POLICIES = 'CspWhitelisting/policies/';

    /**
     * @var ScopeConfigInterface
     */
    protected ScopeConfigInterface $scopeConfig;

    /**
     * @var array|string[]
     */
    protected array $fieldToPolicyMap = [
        'script_src' => 'script-src',
        'style_src' => 'style-src',
        'img_src' => 'img-src',
        'connect_src' => 'connect-src',
        'font_src' => 'font-src',
        'frame_src' => 'frame-src',
    ];

    /**
     * @param ScopeConfigInterface $scopeConfig
     *
     * Initialize dependencies.
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Adds CSP policies from configuration to the list of all policies.
     *
     * @param PolicyList $subject
     * @param array      $policies
     * @return array
     */
    public function afterGetAllPolicies(PolicyList $subject, array $policies): array
    {
        foreach ($this->fieldToPolicyMap as $fieldId => $policyId) {
            $configValue = $this->scopeConfig->getValue(self::XML_PATH_POLICIES . $fieldId);
            if ($configValue) {
                $urls = array_map('trim', explode(',', $configValue));
                foreach ($urls as $url) {
                    if ($url && isset($policies[$policyId])) {
                        $policies[$policyId]->addValue($url, 'host');
                    }
                }
            }
        }

        return $policies;
    }
}
