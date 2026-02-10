# HK2 CSP Whitelisting for Magento 2

## Description

**HK2 CSP Whitelisting** is a Magento 2 extension that allows store administrators to manage **Content Security Policy (CSP) whitelisted URLs** for their storefront.  

The module provides an admin interface to **add, remove, or reset** CSP URLs for policies such as `script-src`, `style-src`, `img-src`, `connect-src`, `font-src`, and `frame-src`.  
All changes are applied **without modifying theme files** and are fully compatible with **Magento 2.4.x CSP enforcement**.

---

## Key Features

* **Admin Configuration**
  Configure CSP policies directly from the Magento Admin Panel without touching code.

* **Add / Remove URLs**
  Easily manage whitelisted URLs for multiple CSP policies.

* **Reset to Default**
  Restore default CSP values for supported third-party services.

* **Default Policies Included**
  Preconfigured URLs for common services like Google, Stripe, Facebook, YouTube, Tailwind CSS, jsDelivr, ContentSquare, NitroPack, and more.

* **CSP-Compliant**
  All assets and policies are managed in compliance with Magento 2.4.x CSP standards.

* **Lightweight**
  No frontend overrides, minimal performance impact, safe for production.

---

## System Requirements

* **Magento Open Source / Adobe Commerce:** 2.4.x or higher  
* **PHP:** 7.4, 8.1, or higher  
* **Database:** MySQL 5.7+ or compatible  

> Magento 2.3.x is end-of-life and not supported.

---

## Installation

### Option 1: Composer (Recommended)

Run the following command from your Magento root directory:

```bash
composer require hktech/csp-whitelisting
````

### Option 2: Manual Installation

1. Create the directory:

   ```
   app/code/Kitto/CspWhitelisting
   ```

2. Copy the module files into the directory.

---

### Enable the Module

After installation, run:

```bash
php bin/magento module:enable Kitto_CspWhitelisting
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy -f
php bin/magento cache:clean
```

---

## Configuration

1. Log in to the Magento Admin Panel.
2. Navigate to **Stores → Configuration → HK2 → CSP Whitelisting**.

### Configuration Options

| Setting              | Description                                                                   |
| -------------------- | ----------------------------------------------------------------------------- |
| **Enable Module**    | Toggle to enable or disable CSP management                                    |
| **CSP Policies**     | Add or remove whitelisted URLs for `script-src`, `style-src`, `img-src`, etc. |
| **Reset to Default** | Restore all policies to the default predefined values                         |

---

## Usage

### Managing CSP Policies

1. Add new URLs to any supported CSP policy.
2. Remove unnecessary URLs.
3. Use **Reset to Default** to restore preconfigured CSP URLs.

> All changes are applied immediately and comply with Magento’s CSP framework.

---

### Verification

After configuration:

* Check browser console for CSP warnings or blocked resources.
* Add a test URL to ensure it is allowed in the specified policy.
* Reset policies and verify default URLs are restored.

---

## Content Security Policy (CSP)

This module **does not introduce inline JavaScript**.
A `csp_whitelist.xml` file is included with default policies, ensuring compatibility with Magento 2.4.x CSP enforcement.
You can safely add third-party service URLs without modifying core files.

---

## Privacy

This extension **does not collect personal or store data**.
All configuration is stored locally in Magento’s `core_config_data` table.

---

## Troubleshooting

* **CSP changes not applied:**

  * Ensure the module is enabled (`php bin/magento module:status`)
  * Flush cache: `php bin/magento cache:flush`
  * Verify CSP URLs in Admin → Stores → Configuration → HK2 → CSP Whitelisting

* **Reset not working:**

  * Ensure write permissions for `core_config_data`
  * Check browser console for CSP warnings

---

## Compatibility & Performance

* Fully compatible with **Magento 2.4.x** frontend architecture
* Lightweight and safe for production
* No theme overrides
* Compatible with static content deployment
* CSP-compliant and secure

---

## Support

For bug reports or feature requests, contact **HK2 support** or use the module repository issue tracker via Magento Marketplace.

---

## License

This extension is licensed under **OSL-3.0**, fully compliant with Magento Marketplace requirements.

---

### ✔ Marketplace Readiness Summary

* Magento 2.4.x compatible
* CSP-compliant
* No inline JavaScript
* Composer-installable
* Admin-configurable
* Lightweight and production-safe

---
