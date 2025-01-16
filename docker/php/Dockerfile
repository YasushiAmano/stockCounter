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

# Node.jsとnpmのインストール
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get update && \
    apt-get install -y --no-install-recommends \
    nodejs=20.* && \
    npm install -g npm@latest && \
    npm install -g yarn && \
    rm -rf /var/lib/apt/lists/*

# 権限の設定
RUN mkdir -p /app/storage && \
    chown -R www-data:www-data /app && \
    chmod -R 755 /app/storage

# Vite開発サーバー用のポート
EXPOSE 5173

# Set the working directory
WORKDIR /app
