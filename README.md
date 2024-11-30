# Требования
- docker
- node.js
- pnpm 

# Установка
Склонировать репозиторий (напр в C:\Projects)
- `pnpm i`
- `pnpm run build`
- `docker.exe compose -f C:\Projects\students5\compose.yaml -p students5 up -d`
- В контейнере intime-php выполнить `php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration`
