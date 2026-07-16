# HK2 CSP Whitelisting

![Version](https://img.shields.io/badge/version-3.0.0-blue?style=flat-square)
![License](https://img.shields.io/badge/license-OSL--3.0-green?style=flat-square)
![Magento](https://img.shields.io/badge/Magento-2.4.4--2.4.9-f97316?style=flat-square&logo=magento&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.1%20%7C%7C%208.2%20%7C%7C%208.3%20%7C%7C%208.4-7c3aed?style=flat-square&logo=php&logoColor=white)
[![Downloads](https://img.shields.io/packagist/dt/hk2/csp?style=flat-square)](https://packagist.org/packages/hk2/csp)

## Overview

HK2 CSP is a Magento 2 extension that enables administrators to manage Content Security Policy (CSP) whitelists dynamically. In addition to a robust set of pre-configured whitelist hosts for third-party scripts, styles, fonts, images, frames, and connections, it provides an admin interface to add custom domains without touching configuration files.

## 🎯 Use Cases

- **Third-Party Integrations**: Safe whitelisting for Google Analytics, Stripe, Facebook, and other standard services.
- **Admin Management**: Direct, safe administrative management of CSP hosts dynamically.

## 🚀 Features

- 🛡 Declares standard CSP policy parameters in `etc/csp.xml`.
- 📦 Out-of-the-box whitelists for popular services (Google, Facebook, Stripe, Hotjar, Sentry, etc.).
- ⚙️ Dynamic admin configurations for directive hosts (`script-src`, `style-src`, `img-src`, `connect-src`, `font-src`, `frame-src`).
- 🔌 Backend validation plugin preventing invalid hosts or header injections.
- 🔄 One-click dynamic "Reset CSP to Defaults" button via Ajax backend redirect.

## 🏗 Architecture

- **Plugin**: `HK2\Csp\Plugin\PolicyListPlugin` intercepts `Magento\Csp\Model\Policy\PolicyList::getAllPolicies` to dynamically merge administrative hosts.
- **Controller**: `HK2\Csp\Controller\Adminhtml\Reset\ResetConfig` handles configuration wipe operations.

## 🧩 Magento Components

### Blocks

- `HK2\Csp\Block\Adminhtml\System\Config\ResetButton`

### Plugins

- `HK2\Csp\Plugin\PolicyListPlugin` on `Magento\Csp\Model\Policy\PolicyList`

### Controllers

- `HK2\Csp\Controller\Adminhtml\Reset\ResetConfig`

## 📦 Requirements

- **Magento version**: 2.4.4 - 2.4.9
- **PHP requirements**: 8.1 || 8.2 || 8.3 || 8.4
- **Required Extension**: `HK2_Core`

## ⚙️ Installation

1. `composer require hk2/csp`
2. `bin/magento module:enable HK2_Csp`
3. `bin/magento setup:upgrade`
4. `bin/magento setup:di:compile`
5. `bin/magento cache:flush`

## 🔧 Configuration

Configure settings under **Stores > Configuration > HK2 > CSP Whitelisting**:

| Field | Description |
|-------|-------------|
| **Script Src URLs** | Comma-separated list of script host domains (e.g. `*.example.com`). |
| **Style Src URLs** | Comma-separated list of style host domains. |
| **Image Src URLs** | Comma-separated list of image host domains. |
| **Connect Src URLs** | Comma-separated list of connect/API host domains. |
| **Font Src URLs** | Comma-separated list of font host domains. |
| **Frame Src URLs** | Comma-separated list of frame/iframe host domains. |
| **Reset CSP** | Button to clear all scopes and restore default whitelists. |

## Usage

Navigate to **Stores > Configuration > HK2 > CSP Whitelisting**, populate domains matching your external integrations, and save. Run `bin/magento cache:flush` to apply.

## 🗄 Database Changes

Not Applicable

## 📂 Module Structure

```text
Block/
└── Adminhtml/
    └── System/
        └── Config/
            └── ResetButton.php
Controller/
└── Adminhtml/
    └── Reset/
        └── ResetConfig.php
Plugin/
└── PolicyListPlugin.php
etc/
├── adminhtml/
│   ├── menu.xml
│   ├── routes.xml
│   └── system.xml
├── acl.xml
├── config.xml
├── csp.xml
├── csp_whitelist.xml
├── di.xml
└── module.xml
view/
└── adminhtml/
    └── templates/
        └── system/
            └── config/
                └── reset_button.phtml
```

## 📈 Performance Considerations

The policies list is cached inside Magento's standard configuration cache, preventing database queries or regex calculations on standard page loads.

## 🔐 Security Considerations

- **Input Validation**: `isValidCspHost` prevents semicolons, commas, and white spaces in custom values, protecting the headers against header splitting or policy injection attacks.

## Compatibility

Reference: [docs/compatibility.md](docs/compatibility.md)

| Platform | Supported Versions |
|----------|-------------------|
| Magento  | 2.4.4 - 2.4.9     |
| PHP      | 8.1, 8.2, 8.3, 8.4 |

## 🛠 Troubleshooting

### Dynamic values not appearing in CSP header

Verify you have flushed the configuration cache after making changes: `bin/magento cache:flush`.

## 🤝 Contributing

Contributions are welcome! If you'd like to improve the installer:

- ⭐ **Star this repository** (Helps others find it!)
- 🍴 Fork the project
- 🐛 Report bugs
- 💡 Suggest new features
- 🤝 Contribute improvements

Every ⭐ helps increase the visibility of the project and motivates further development.

## ⚖️ Disclaimer

The author provides this installation script "as is" without any warranties. Users are responsible for ensuring that running this script complies with their internal security and software requirements.

## 🤝 Support

For bug reports, feature requests, and general support:

- **Author**: Basant Mandal
- **Email**: <support@basantmandal.in>
- **Website**: <https://www.basantmandal.in>

## License

This project is licensed under the OSL 3.0 License. See the [LICENSE.txt](LICENSE.txt) file for details.

---
