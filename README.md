
````markdown
# 📦 Laravel Neshan

پکیج **`laravel-neshan`** یک واسط قدرتمند، توسعه‌پذیر و قابل‌اطمینان برای تعامل با [API نقشه نشان](https://platform.neshan.org/) در فریم‌ورک Laravel است. این پکیج تمامی سرویس‌های کلیدی ارائه‌شده توسط نقشه نشان را پوشش می‌دهد و مناسب پروژه‌های واقعی با معماری اصول‌گرا می‌باشد.

---

## ✅ امکانات پشتیبانی‌شده

- 🗺️ Static Map
- 📍 Geocoding (تبدیل آدرس به مختصات)
- 🧭 Reverse Geocoding (تبدیل مختصات به آدرس)
- 🔎 Search (جستجوی متنی)
- 🚦 Direction (مسیریابی با یا بدون در نظر گرفتن ترافیک)
- 📊 Map Matching (نگاشت مسیر به نقاط GPS)

---

## ⚙️ نصب

برای نصب پکیج از Composer استفاده کنید:

```bash
composer require denason/laravel-neshan
````

---

## 🔐 پیکربندی

مقادیر زیر را به فایل `.env` پروژه‌ی خود اضافه کنید:

```env
NESHAN_API_BASE_URL=https://api.neshan.org
NESHAN_MAP_API_KEY=service.f0b032318487462a8dfa467aff93408a
NESHAN_SERVICE_API_KEY=service.a53814e21deb45bfa47e97804674b1b2
```

سپس فایل پیکربندی را منتشر نمایید:

```bash
php artisan vendor:publish --tag=neshan-config
```

---

## 🚀 استفاده سریع از سرویس مسیر‌یابی (Direction)

```php
use Denason\Neshan\Facades\Neshan;

$response = Neshan()
    ->direction()
    ->origin(35.6892, 51.3890)
    ->destination(35.7000, 51.4000)
    ->type('car') // نوع وسیله نقلیه: car | motor | truck
    ->withTraffic() // یا ->withoutTraffic()
    ->avoidOddEvenZone()
    ->avoidTrafficZone()
    ->alternative()
    ->bearing(90)
    ->get();
```

> خروجی به صورت `array` از اطلاعات کامل مسیر ارائه می‌شود.

---


---

## 📚 مستندات کامل

مستندات هر سرویس به‌زودی در بخش [Wiki پکیج در GitHub](https://github.com/username/laravel-neshan/wiki) قرار خواهد گرفت.
در آنجا می‌توانید نمونه‌کدها، توضیحات پارامترها، و جزئیات فنی هر API را مشاهده نمایید.

---

## 🪪 مجوز

این پکیج تحت مجوز آزاد [MIT License](LICENSE) منتشر شده است.

---

```

```
