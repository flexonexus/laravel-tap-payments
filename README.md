# Laravel Tap Payments

[![Latest Version](https://img.shields.io/packagist/v/flexo/laravel-tap-payments.svg?style=flat-square)](https://packagist.org/packages/flexo/laravel-tap-payments)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/flexo-nexus/laravel-tap-payments/tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/flexo-nexus/laravel-tap-payments/actions)
[![License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](#-license)

> 🚀 Elegant Laravel integration with [Tap Payments](https://www.tap.company/): charges, refunds, webhooks — the clean Laravel way.

---

## ✨ Features

- 🔑 Simple **Facade API**: `Tap::createCharge()`, `Tap::refundCharge()`, etc.
- ⚙️ **Configurable** via `.env` (`TAP_SECRET_KEY`, `TAP_MODE`, etc.)
- 🔔 Built-in **Webhook signature verification**
- 📦 PSR-4 autoload & **Laravel auto-discovery**
- 🧪 **Testbench support** for easy unit testing

---

## 📦 Installation & Setup

Follow these steps to fully install and configure the package:

### 1. Install via Composer
```bash
composer require flexonexus/laravel-tap-payments
```

### 2. Publish the Config File
```bash
php artisan vendor:publish --tag=tap-config
```
This will create:
```
config/tap.php
```

### 3. Add Environment Variables
In your `.env` file:

```dotenv
TAP_MERCHANT_ID=your_merchant_id_here # Your Merchant ID
TAP_SECRET_KEY=sk_test_xxx   # Your Tap secret key
TAP_PUBLIC_KEY=pk_test_xxx   # Your Tap public key
TAP_WEBHOOK_SECRET=whsec_xxx # Webhook secret for signature verification
TAP_MODE=sandbox             # sandbox | live
```

### 4. Configure Webhook URL
Set the webhook endpoint in your Tap dashboard:

```
https://your-domain.com/tap/webhook
```

The package already registers this route automatically.

### 5. Clear Cached Configs
If your app uses config caching, run:

```bash
php artisan config:clear
```

### 6. Test the Integration
Use the Facade to create a test charge:

```php
use Tap;

$charge = Tap::createCharge([
    'amount'   => 50,
    'currency' => 'USD',
    'customer' => [
        'first_name' => 'Test',
        'email'      => 'test@example.com',
        'phone'      => ['country_code' => '966', 'number' => '500000000'],
    ],
    'merchant' => ['id' => config('tap.merchant_id')],
    'source'   => ['id' => 'src_all'],
    'redirect' => ['url' => route('checkout.callback')],
    'description' => 'Order #1001',
    // ...any other Tap fields you need
]);

dd($charge);
```

If you see a JSON response with a `charge_id`, 🎉 the package is working.

---

## 🚀 Usage Examples

### Create a Charge
```php
$charge = Tap::createCharge([
    'amount'   => 50,
    'currency' => 'USD',
    'customer' => [
        'first_name' => 'Mohamed',
        'email'      => 'mohamed@example.com',
        'phone'      => ['country_code' => '966', 'number' => '500000000'],
    ],
    'merchant' => ['id' => config('tap.merchant_id')],
    'source'   => ['id' => 'src_all'],
    'redirect' => ['url' => route('checkout.callback')],
    'description' => 'Order #1234',
    // ...any other Tap fields you need
]);
```

### Retrieve a Charge
```php
$charge = Tap::retrieveCharge($charge['id']);
```

### Refund a Charge
```php
$refund = Tap::refundCharge($charge['id'], [
    'amount' => 150,
    'reason' => 'customer_request'
]);
```

---

## 🔔 Webhooks

- The package registers `/tap/webhook` automatically.
- All requests are verified with `TAP_WEBHOOK_SECRET`.

### Example: Listen for events
```php
Event::listen('tap::charge.succeeded', function ($payload) {
    // Update your order, mark it as paid
});
```

---

## 🧪 Testing

```bash
composer test
```

This uses PHPUnit with Orchestra Testbench.

---

## 🤝 Contributing

PRs are welcome!  
Please run `composer test` before submitting.

---

## 💡 Credits

- Built with ❤️ by [Flexo Nexus](https://flexonexus.com)
- Tap Payments API — [https://www.tap.company](https://www.tap.company)
