# HK2 CSP Whitelisting for Magento 2

<div align="center">

![Version](https://img.shields.io/badge/version-1.0.0-blue?style=for-the-badge)
[![Website](https://img.shields.io/badge/website-000?style=for-the-badge)](https://www.basantmandal.in/)
[![LinkedIn](https://img.shields.io/badge/linkedin-0A66C2?style=for-the-badge\&logo=linkedin)](https://www.linkedin.com/in/basantmandal/)

</div>

---

## Overview

**HK2 CSP Whitelisting** is a Magento 2 extension that provides a **centralized, admin-managed interface** to configure
and maintain **Content Security Policy (CSP) whitelists** without editing XML files or touching core code.

The module is designed for:

* Managing CSP directives from Admin UI
* Safely allowing third-party scripts, styles, and assets
* Debugging CSP violations during development
* Maintaining Magento 2.4.x CSP compliance

The extension works **alongside Magento’s native CSP system**, automatically merging admin-defined values with
`csp_whitelist.xml`.

> ⚠ **Important:**
> For manual installation, the **HK2 Core** package (`hk2/core`) must be installed first.

---

## Key Features

* **Admin-Managed CSP Directives**  
  Configure and manage CSP policies directly from the Magento Admin Panel — no XML or code changes required.

* **Supported CSP Policies**  
  Manage commonly used CSP directives including:
    * `script-src`
    * `style-src`
    * `img-src`
    * `connect-src`
    * `font-src`
    * `frame-src`

* **Automatic CSP Merging**  
  Admin-defined values are **safely merged** with existing `csp_whitelist.xml` rules, never overwritten.

* **Multi-Scope Configuration**  
  Fully supports all Magento configuration scopes:
    * Default
    * Website
    * Store View

* **One-Click Reset to Default**  
  Instantly clear all saved CSP values and restore fallback behavior using a dedicated admin reset button.

* **Default Policies Included**  
  Ships with preconfigured CSP rules for commonly used third-party services such as:
  Google, Stripe, Facebook, YouTube, Tailwind CSS, jsDelivr, ContentSquare, NitroPack, and more.

* **CSP-Safe & Magento-Compliant**  
  Built in full compliance with Magento 2.4.x CSP standards:
    * No inline JavaScript
    * No `unsafe-inline`
    * No `unsafe-eval`

* **Magento-Native Architecture**  
  Leverages Magento’s native CSP collectors, configuration, and caching systems for maximum compatibility.

* **Lightweight & Production-Safe**  
  No frontend overrides, no performance impact, and fully compatible with production mode.

## System Requirements

* **Magento Open Source / Adobe Commerce:** 2.4.x
* **PHP:** 8.1 or higher
* **Database:** MySQL 8.0 / MariaDB 10.4+
* **Dependency:** `hk2/core` v1.0+ (required)

> Magento 2.3.x is end-of-life and not supported.

---

## Installation

### Composer (Recommended)

From the Magento root directory:

```bash
composer require hk2/csp-whitelisting
```

This automatically installs the required **HK2 Core** dependency.

---

### Manual Installation

1. Install **HK2 Core**:

```bash
app/code/HK2/Core
```

2. Create the module directory:

```bash
app/code/HK2/CspWhitelisting
```

3. Copy the module files into the directory.

---

### Enable the Module

```bash
php bin/magento module:enable HK2_CspWhitelisting
php bin/magento setup:upgrade
php bin/magento cache:flush
```

Optional (production mode):

```bash
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy
```

---

## Configuration

Navigate to:

**Stores → Configuration → HK2 → CSP Whitelisting**

### Available Options

| Setting          | Description                                       |
|------------------|---------------------------------------------------|
| Script Src URLs  | Comma-separated list for `script-src` directive   |
| Style Src URLs   | Comma-separated list for `style-src` directive    |
| Image Src URLs   | Comma-separated list for `img-src` directive      |
| Connect Src URLs | Comma-separated list for `connect-src` directive  |
| Font Src URLs    | Comma-separated list for `font-src` directive     |
| Frame Src URLs   | Comma-separated list for `frame-src` directive    |
| Reset CSP Button | Clears all saved CSP values and restores defaults |

---

## Reset CSP Behavior

The **Reset CSP** button:

* Clears all saved values across **all scopes**
* Restores fallback behavior from `csp_whitelist.xml`
* Immediately clears admin UI textareas
* Re-initializes Magento config cache safely

This follows Magento’s native **“Reset to Default”** behavior.

---

## CSP Merging Logic

This module **does not override** Magento CSP rules.

Final CSP header is composed of:

1. Core Magento CSP rules
2. Values from `csp_whitelist.xml`
3. Admin-configured values (merged per directive)

This ensures:

* Maximum compatibility
* Upgrade safety
* Predictable CSP behavior

---

## Testing & Verification

### Frontend Testing

You can verify CSP behavior using:

* Browser DevTools → **Network → Response Headers**
* Browser Console CSP violation warnings
* Test scripts/styles from allowed and blocked sources

### Sample Test Page

Create a CMS page and try loading:

* Allowed external JS (should load)
* Disallowed external JS (should be blocked)

---

## Content Security Policy (CSP)

This extension is fully compatible with Magento 2.4.x CSP system.

The module **does not use**:

* Inline JavaScript
* `unsafe-inline`
* `unsafe-eval`

### Supported Directives

* `script-src`
* `style-src`
* `img-src`
* `connect-src`
* `font-src`
* `frame-src`

All values are validated and merged safely.

---

## Privacy & Data Usage

* No personal data is collected
* No tracking or analytics
* No background requests
* External requests only occur if explicitly whitelisted

This module is **GDPR-safe by design**.

---

## Compatibility & Performance

* Fully compatible with Magento 2.4.x
* Safe for production mode
* Compatible with static content deployment
* No performance impact on frontend or admin

---

## Known Limitations

* Does not modify core CSP logic
* Does not auto-detect CSP violations
* Inline scripts must still be refactored to comply with CSP

---

## Support & Contribution

Contributions are welcome:

1. Fork the repository
2. Create a feature branch
3. Commit and push your changes
4. Open a pull request

Support availability may vary.

---

## Disclaimer

This extension is provided **as-is**, without warranty of any kind.
The author is not liable for damages resulting from the use of this module.

---

## License

**Open Software License (OSL-3.0)**
[https://opensource.org/licenses/OSL-3.0](https://opensource.org/licenses/OSL-3.0)

---

## Author

**Basant Mandal**
HK2 – Hash Tag Kitto

* Website: [https://www.basantmandal.in](https://www.basantmandal.in)
* LinkedIn: [https://www.linkedin.com/in/basantmandal](https://www.linkedin.com/in/basantmandal)
* Email: [support@basantmandal.in](mailto:support@basantmandal.in)

---
