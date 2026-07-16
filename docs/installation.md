# HK2 Csp

## Overview

HK2 CSP is a Magento 2 extension that enables administrators to manage Content Security Policy (CSP) whitelists dynamically. In addition to a robust set of pre-configured whitelist hosts for third-party scripts, styles, fonts, images, frames, and connections, it provides an admin interface to add custom domains without touching configuration files.

## 📦 Installation

### ⚙️ Install Package

```bash
composer require hk2/csp
```

> This installs the module and its dependency `hk2/core ^1.0`.

### Step-1: Enable Module

```bash
bin/magento module:enable HK2_Csp
```

### Step-2: Upgrade Database

```bash
bin/magento setup:upgrade
```

### Step-3: Compile

```bash
bin/magento setup:di:compile
```

### Step-4: Flush Cache

```bash
bin/magento cache:flush
```

### Step-5: Verification

To verify that the module is successfully installed:
1. Navigate to **Stores > Configuration > HK2 > CSP Whitelisting** in the admin panel and verify settings fields render correctly.
2. In the browser, inspect the HTTP headers on a storefront page and verify that the `Content-Security-Policy` header is active.

## 🛠 Uninstallation

### Step-1: Disable Module

```bash
bin/magento module:disable HK2_Csp
```

### Step-2: Remove Package

```bash
composer remove hk2/csp
```

### Step-3: Upgrade

```bash
bin/magento setup:upgrade
```

### Step-4: Flush Cache

```bash
bin/magento cache:flush
```

### Step-5: Verification

Confirm that custom URLs are deleted from core_config_data, and that the default Magento CSP restrictions are restored.

## 🛠 Troubleshooting

### Module not detected
Ensure that the code is in the correct directory `app/code/HK2/Csp/` and that the file permissions allow Magento to read the module files. Run `bin/magento setup:upgrade` to register the module.

### Composer conflicts
Verify that `hk2/core` is successfully installed as it is a required dependency.

### Setup upgrade failures
Ensure that your database connection is active and that your database user has sufficient privileges to perform schema/data updates.

### Compilation failures
If Dependency Injection compilation (`setup:di:compile`) fails, clear the generated code directory by running `rm -rf generated/code/* generated/metadata/*` and retry compilation.

### Cache issues
If changes do not appear after installation or uninstallation, flush the cache using `bin/magento cache:flush` and clean the cache with `bin/magento cache:clean`.

### Permissions issues
Ensure the Magento files and directories are owned by the correct web user and have the appropriate write permissions. Run standard Magento permission fixes:
```bash
find var generated vendor pub/static pub/media app/etc -type f -exec chmod g+w {} +
find var generated vendor pub/static pub/media app/etc -type d -exec chmod g+ws {} +
```

### PHP compatibility issues
This module requires PHP 8.1, 8.2, 8.3, or 8.4. Verify your current CLI PHP version using `php -v`.

## 🤝 Support

For bug reports, feature requests, and general support:

- **Author**: Basant Mandal
- **Email**: support@basantmandal.in
- **Website**: https://www.basantmandal.in
