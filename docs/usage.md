# Usage Guide

## Three-Layer CSP Architecture

This module manages CSP policies across three distinct layers, each with a specific responsibility:

```
Layer 1: Base CSP (etc/csp.xml)
├── 9 directives (script-src, style-src, img-src, etc.)
├── Report-only mode — violations logged, nothing blocked
└── Provides baseline security visibility

Layer 2: Pre-built Whitelist (etc/csp_whitelist.xml)
├── 80+ trusted hosts across 7 directives
├── Curated, version-controlled, updated per release
└── Covers analytics, payments, CDNs, social media, embeds

Layer 3: Admin Custom Whitelist (DB-persisted)
├── 6 multi-line textarea fields
├── Per-store-view configuration
├── Survives module updates
└── One-click reset available
```

All three layers are merged at runtime by a plugin on `Magento\Csp\Model\Policy\PolicyList::getAllPolicies`.

## Admin Configuration

### Accessing the Settings

1. Log in to the Magento Admin Panel.
2. Navigate to **Stores → Settings → Configuration**.
3. Under the **HK2** tab in the left panel, select **CSP Whitelisting**.

### Adding Custom Hosts

Each directive field accepts one host per line. Ports and protocols are optional.

**Examples:**

```
https://fonts.googleapis.com
https://www.google-analytics.com
https://js.stripe.com
https://static.klaviyo.com
cdn.jsdelivr.net
```

> Do not include `script-src`, `style-src` etc. in the field values — the directive is implied by the field label.

### Per-Store-View Scope

Use the **Store View** selector in the top-left corner of the configuration page to set different whitelists for different websites, stores, or store views. This is useful for:

- Multilingual stores loading different analytics scripts per locale.
- Multi-brand deployments with different third-party integrations.
- Staging vs. production environments sharing the same code base.

### Resetting the Custom Whitelist

1. Navigate to the CSP Whitelisting configuration page.
2. Click **Reset Custom CSP Whitelist**.
3. Confirm the action.

This deletes all six custom fields from the database for the current scope. The base CSP and pre-built whitelist are not affected.

## Best Practices

### Audit First, Allow Later

1. Open your store in a browser with DevTools open (Chrome/Firefox).
2. Monitor the **Console** tab for CSP violation warnings.
3. Note the blocked host and the directive it violates.
4. Add only the required hosts to the corresponding admin field.

### Prefer HTTPS

Always use `https://` prefixes in custom entries. Modern browsers may block mixed content if your store is served over HTTPS and whitelisted sources are HTTP.

### Avoid Wildcards

Wildcard entries (`*`) defeat the purpose of CSP. Use specific hostnames whenever possible. If you must use a wildcard (e.g., for a subdomain-based SaaS), add it through the admin custom field — never edit the pre-built `csp_whitelist.xml`.

### Monitor Violations in Production

CSP violation logs appear in:

- **Browser console** at `console` tab (during development).
- **Magento var/log/** — depending on your Magento CSP reporting configuration.
- **External report-uri endpoint** — if configured via `etc/csp.xml`.

Set up a `report-uri` or use a service like `report-uri.com` or `sentry.io` to collect violations from production.

### Test Before Enforcing

Start with **Report-Only** mode (the default). Once you are confident no legitimate resources are being blocked, switch to enforcement mode by changing `report-only` to `enforce` in `etc/csp.xml`:

```xml
<policy name="script-src" report-only="false">
```

> Always test enforcement mode in a staging environment first.

## Adding New Hosts to the Pre-built Whitelist

If you maintain a fork or contribute to the module, add new entries to `etc/csp_whitelist.xml`:

1. Identify the CSP directive the host belongs to.
2. Add the host in alphabetical order within the corresponding `<directive>` block.
3. Verify the host serves content over HTTPS.
4. Open a pull request.

## Testing CSP After Changes

### Browser DevTools

1. Open Chrome/Firefox DevTools (`F12`).
2. Go to the **Network** tab and reload the page.
3. Look for blocked requests (CSP violations appear with status `(blocked:...)`).
4. Check the **Console** tab for formatted CSP warning messages.

### Curl

```bash
curl -sI https://your-store.com | grep -i content-security-policy
```

### Online CSP Evaluators

- [CSP Evaluator](https://csp-evaluator.withgoogle.com/) by Google
- [CSP Scanner](https://cspscanner.com/) — paste your policy header

### Manual Header Inspection

```bash
curl -sI https://your-store.com | grep -i "content-security-policy"
```

Compare the output against your expected whitelist to verify custom entries are being merged correctly.

## Troubleshooting

| Problem | Check |
|---|---|
| Custom whitelist not applied | Flush config cache: `php bin/magento cache:clean config` |
| CSP header missing entirely | Confirm `Magento_Csp` is enabled and no module disables it |
| Admin page shows "not found" | Verify `HK2_Core` is installed and enabled |
| Plugin not merging | Check `etc/module.xml` sequences `HK2_Core` and `Magento_Csp` |
| Reset button has no effect | Ensure you are in the correct store view scope |
