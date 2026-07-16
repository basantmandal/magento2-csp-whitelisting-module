<?php

declare(strict_types=1);

namespace HK2\Csp\Plugin;

use Magento\Csp\Model\Policy\PolicyList;
use Magento\Framework\App\Config\ScopeConfigInterface;

class PolicyListPlugin
{
    public const string XML_PATH_POLICIES = 'hk2_csp_section1/hk2_csp_section1_group2/';

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
     * @param array $policies
     * @return array
     */
    public function afterGetAllPolicies(PolicyList $subject, array $policies): array
    {
        foreach ($this->fieldToPolicyMap as $fieldId => $policyId) {
            $configValue = $this->scopeConfig->getValue(self::XML_PATH_POLICIES . $fieldId);
            if ($configValue) {
                $urls = array_map('trim', explode(',', $configValue));
                foreach ($urls as $url) {
                    if ($url && $this->isValidCspHost($url) && isset($policies[$policyId])) {
                        $policies[$policyId]->addValue($url, 'host');
                    }
                }
            }
        }

        return $policies;
    }

    /**
     * Validates if a given string is a valid CSP host. Prevents injection of malicious characters.
     *
     * @param string $host
     * @return bool
     */
    private function isValidCspHost(string $host): bool
    {
        // Deny whitespace, semicolons, and commas to prevent injection
        if (preg_match('/[\s;,]/', $host)) {
            return false;
        }

        // Allow basic valid CSP characters: letters, numbers, hyphens, periods,
        // colons (for schemes/ports), slashes (for paths), asterisks (for wildcards),
        // single quotes (for keywords like 'self'), and common URL characters (?, =, &, ~, %, _)
        return (bool)preg_match('/^[\'*a-zA-Z0-9\-._~%:/?=&]+$/', $host);
    }
}
