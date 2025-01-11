FROM dunglas/frankenphp:1

RUN install-php-extensions \
    pcntl \
    pdo_mysql \
    gd \
    intl \
    zip \
    opcache \
    bcmath

# cwebp導入
RUN apt-get update && \
    apt-get -y install --no-install-recommends webp=1.2.4* && \
    rm -rf /var/lib/apt/lists/*

# Composer
SHELL ["/bin/bash", "-o", "pipefail", "-c"]
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug

# .bashrcの設定を追加
COPY ./docker/php/bashrc /root/.bashrc

# Set the working directory
WORKDIR /app
# Copy composer.json and composer.lock to the working directory
COPY ./src .
# Composer installを追加
RUN composer install --no-dev --optimize-autoloader \
    && composer require --dev barryvdh/laravel-ide-helper \
    && composer require laravel-lang/lang \
    && composer require laravel-lang/publisher \
    && composer require laravel/octane

# 権限の設定
RUN chown -R www-data:www-data /app \
    && chmod -R 755 /app/storage

# Node.jsとnpmのインストール
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get update && \
    apt-get install -y --no-install-recommends \
    nodejs=20.* && \
    npm install -g npm@latest && \
    # yarnのインストール（必要な場合）
    npm install -g yarn && \
    # プロジェクトの依存関係をインストール
    npm install && \
    npm run build && \
    # キャッシュクリア
    npm cache clean --force && \
    rm -rf /var/lib/apt/lists/*
# Vite開発サーバー用のポートを開放
EXPOSE 5173
