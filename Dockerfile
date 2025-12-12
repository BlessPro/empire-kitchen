FROM php:8.2-fpm AS base

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    curl \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install -j$(nproc) \
        bcmath \
        gd \
        pdo \
        pdo_pgsql \
        pcntl \
        zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install Node.js (for Vite / asset builds)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@10 \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Install PHP dependencies (no scripts until code is present)
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-progress --no-interaction --optimize-autoloader --no-scripts

# Install Node dependencies (for Vite)
COPY package.json package-lock.json ./
RUN npm ci --no-audit --no-fund

# Copy application code
COPY . .

# Now run composer scripts (artisan available) and build assets
RUN composer install --no-dev --prefer-dist --no-progress --no-interaction --optimize-autoloader
RUN mkdir -p storage/framework/{cache/data,sessions,views} bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache
RUN npm run build

# Start Laravel's built-in server on the provided port (Render sets $PORT)
CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=${PORT:-8000}"]
