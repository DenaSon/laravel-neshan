
---

````markdown
# 📦 Laravel Neshan

پکیج `laravel-neshan` یک واسط قدرتمند، توسعه‌پذیر و قابل اطمینان برای تعامل با [API نقشه نشان](https://developers.neshan.org) در فریم‌ورک Laravel است. این پکیج با رویکرد مهندسی‌ شده طراحی شده و تمامی سرویس‌های کلیدی ارائه‌شده توسط نقشه نشان را پوشش می‌دهد.

---

## ✅ امکانات پشتیبانی‌شده

- 🗺️ Static Map
- 📍 Geocoding (تبدیل آدرس به مختصات)
- 🧭 Reverse Geocoding (تبدیل مختصات به آدرس)
- 🔎 Search (جستجوی متنی)
- 🚦 Direction (مسیریابی با و بدون ترافیک)
- 📊 Map Matching (نگاشت مسیر به نقاط GPS)

---

## ⚙️ نصب

```bash
composer require denason/laravel-neshan
````

---

## 🔐 پیکربندی

مقادیر زیر را به فایل `.env` خود اضافه کنید:

```env
NESHAN_API_BASE_URL=https://api.neshan.org
NESHAN_MAP_API_KEY=service.f0b032318487462a8dfa467aff93408a
NESHAN_SERVICE_API_KEY=service.a53814e21deb45bfa47e97804674b1b2
```

برای انتشار فایل پیکربندی:

```bash
php artisan vendor:publish --tag=neshan-config
```

---

## 🚀 استفاده سریع از سرویس مسیریابی (Direction)

```php
use Denason\Neshan\Facades\Neshan;

$response = Neshan()
    ->direction()
    ->origin(35.6892, 51.3890)
    ->destination(35.7000, 51.4000)
    ->type('car') // انتخاب نوع وسیله نقلیه (car, motor, truck)
    ->withTraffic() // یا ->withoutTraffic()
    ->avoidOddEvenZone()
    ->avoidTrafficZone()
    ->alternative()
    ->bearing(90)
    ->get();
```

> پاسخ به‌صورت آرایه PHP شامل اطلاعات کامل مسیر خواهد بود.



## 📂 ساختار پوشه‌ها



---

## 📚 مستندات کامل

مستندات کامل بزودی در بخش wiki قرار میگیرد
---

## 🪪 مجوز

پروانه نرم‌افزار آزاد [MIT License](LICENSE).

---

## 🤝 مشارکت

Pull Request و Issue پذیرفته می‌شود. لطفاً پیش از آن، [Contribution Guide](CONTRIBUTING.md) را مطالعه کنید.


