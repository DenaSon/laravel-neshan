---

````markdown
# 📍 نقشه نشان برای لاراول

یک پکیج  برای اتصال به [API نقشه  نشان](https://developers.neshan.org/api/static) در فریم‌ورک Laravel.  
براحتی از سرویس های نقشه نشان در پروژه های لاراول خود استفاده کنید

---

## 🚀 نصب پکیج

از طریق کامپوزر نصب کنید:

```bash
composer require denason/laravel-neshan
````

در صورت نیاز، فایل پیکربندی را منتشر کنید:

```bash
php artisan vendor:publish --tag=config
```

---

## ⚙️ پیکربندی

مقادیر کلید API و آدرس پایه API را در فایل `.env` پروژه قرار دهید:

```env
NESHAN_STATIC_MAP_API_KEY=کلید-شخصی-شما
NESHAN_STATIC_MAP_BASE_URL=https://api.neshan.org/v4/static
```

ساختار فایل `config/neshan.php` به این شکل است:

```php
'static_map' => [
    'api_key' => env('NESHAN_STATIC_MAP_API_KEY'),
    'base_url' => env('NESHAN_STATIC_MAP_BASE_URL', 'https://api.neshan.org/v4/static'),
],
```

---

## ✅ نحوه استفاده

استفاده از **Facade**:

```php
use Neshan;

$lat = 35.6892;
$lng = 51.3890;

$url = Neshan::staticMap()->generate($lat, $lng);
$image = Neshan::staticMap()->fetchImage($url);

return response($image)->header('Content-Type', 'image/png');
```

یا با استفاده از **Helper**:

```php
$url = staticMap()->generate(35.6892, 51.3890);
```

---

## 📦 امکانات پکیج

* تولید لینک نقشه ایستا با پارامترهای مختلف
* دریافت مستقیم تصویر نقشه (فرمت PNG)
* بررسی اعتبار ورودی‌ها (زوم، ابعاد، نوع نقشه و ...)
* ساختار ماژولار و مبتنی بر اصول SOLID
* یکپارچه با معماری لاراول (Service Provider، Facade، Helper و Config)

---

## 📌 نقشه راه توسعه

* افزودن سرویس جستجو (Search)
* افزودن موقعیت‌یابی معکوس (Reverse Geocoding)
* مسیریابی (Routing)
* مدیریت چند سرویس با ساختار Service Tag

---

## 🧪 تست

برای اجرای تست‌ها:

```bash
php artisan test
```

این پکیج شامل تست‌های انتگرال‌گیری (Integration Test) برای بررسی ارتباط با API نشان است.
حتماً از کلید API معتبر در فایل `.env` استفاده کنید تا تست‌ها با موفقیت اجرا شوند.

---

## 📝 مجوز

این پکیج با مجوز MIT به‌صورت متن‌باز ارائه شده است.
© توسعه یافته توسط **Denason**

```

