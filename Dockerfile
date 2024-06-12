# PHPのバージョンを指定する
FROM php:8.3.4-fpm

# 必要なパッケージのインストール
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Checking installed libraries
RUN ldconfig -p | grep -E 'libjpeg|libfreetype'

# Node.jsとnpmのインストール
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash - \
    && apt-get install -y nodejs \
    && apt-get install -y npm \
    && node -v \
    && npm -v

# PHPの拡張機能をインストール、GDをJPEGとFreeTypeで構成
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Composerをインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ワーキングディレクトリを設定
WORKDIR /var/www

# アプリケーションのソースコードをコピー
COPY . /var/www

# 必要なディレクトリを作成し、パーミッションを設定
RUN mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache \
    && chmod -R 775 storage bootstrap/cache

# スタートアップスクリプトをコピー
COPY .docker/startup.sh /usr/local/bin/startup.sh
RUN chmod +x /usr/local/bin/startup.sh

# スタートアップスクリプトを実行
CMD ["/usr/local/bin/startup.sh"]
