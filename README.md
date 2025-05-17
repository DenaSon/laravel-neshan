# 📍 نقشه نشان برای لاراول

یک پکیج کاربردی برای استفاده از سرویس نقشه ایستای نشان در فریم‌ورک Laravel.  
این پکیج به شما امکان می‌دهد به سادگی با چند خط کد، نقشه‌های ایستا بسازید و تصویر آن‌ها را دریافت کنید.



## 🚀 نصب پکیج

برای نصب پکیج از طریق Composer دستور زیر را اجرا کنید:

```bash
composer require denason/laravel-neshan
```

---

## ⚙️ پیکربندی

مقادیر کلید API و آدرس پایه API را در فایل `.env` پروژه خود تنظیم کنید:
دریافت کلید دسترسی به API : https://platform.neshan.org/api/getting-started/
```env
NESHAN_STATIC_MAP_API_KEY=کلید-شخصی-شما
NESHAN_STATIC_MAP_BASE_URL=https://api.neshan.org/v4/static
```


ساختار فایل پیکربندی `config/neshan.php` به شکل زیر است:

```php
'static_map' => [
    'api_key' => env('NESHAN_STATIC_MAP_API_KEY'),
    'base_url' => env('NESHAN_STATIC_MAP_BASE_URL', 'https://api.neshan.org/v4/static'),
],
```

---

## ✅ نحوه استفاده

### استفاده از Facade

```php
use Neshan;

$lat = 35.6892;
$lng = 51.3890;

$url = Neshan::staticMap()->generate($lat, $lng);
$image = Neshan::staticMap()->fetchImage($url);

return response($image)->header('Content-Type', 'image/png');
```

### استفاده از Helper

```php
$url = staticMap()->generate(35.6892, 51.3890);
```

---

## 📦 امکانات پکیج

* تولید لینک نقشه ایستا با قابلیت تنظیم پارامترهای مختلف مانند زوم، اندازه و نوع نقشه
* دریافت مستقیم تصویر نقشه در قالب PNG
* اعتبارسنجی ورودی‌ها برای جلوگیری از خطاهای رایج
* پیاده‌سازی اصول SOLID و ساختار ماژولار
* یکپارچگی کامل با معماری لاراول شامل Service Provider، Facade، Helper و Config

---

## 📌 نقشه راه توسعه

در نسخه‌های بعدی قصد داریم امکانات زیر را اضافه کنیم:

* سرویس جستجو (Search)
* موقعیت‌یابی معکوس (Reverse Geocoding)
* مسیریابی (Routing)
* مدیریت همزمان چند سرویس از طریق ساختار Service Tag

---

## 🧪 تست

برای اجرای تست‌ها دستور زیر را اجرا کنید:

```bash
php artisan test
```

توجه داشته باشید برای اجرای موفق تست‌ها به کلید API معتبر در فایل `.env` نیاز دارید.

---

## 📝 مجوز

این پکیج تحت مجوز MIT به صورت متن‌باز ارائه شده است.
© توسعه یافته توسط Denason


