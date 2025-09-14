# استخدم صورة PHP مع Apache
FROM php:8.2-apache

# تثبيت بعض الامتدادات المطلوبة لـ Laravel
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl

# تفعيل mod_rewrite في Apache
RUN a2enmod rewrite

# تثبيت Composer
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

# تعيين مجلد العمل
WORKDIR /var/www/html

# نسخ الملفات إلى داخل الحاوية
COPY . .

# تثبيت البكجات
RUN composer install --no-dev --optimize-autoloader

# إعطاء الصلاحيات لمجلد التخزين و bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# نسخ ملف إعدادات Apache
COPY ./docker/apache/laravel.conf /etc/apache2/sites-available/000-default.conf

# فتح البورت 80
EXPOSE 80

# تشغيل Apache
CMD ["apache2-foreground"]
