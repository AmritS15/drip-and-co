#!/usr/bin/env bash
# Run on the production server after `git pull` / `git reset --hard`.
# Installs deps, builds Vite assets (required — /public/build is not in git), runs migrations & caches.

set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$ROOT"

echo "==> Deploy from: $ROOT"

export COMPOSER_ALLOW_SUPERUSER="${COMPOSER_ALLOW_SUPERUSER:-1}"

if command -v composer >/dev/null 2>&1; then
  composer install --no-dev --optimize-autoloader --no-interaction
else
  echo "ERROR: composer not found on PATH" >&2
  exit 1
fi

if command -v npm >/dev/null 2>&1; then
  echo "==> npm ci && npm run build (Vite)"
  npm ci
  npm run build
else
  echo "WARNING: npm not found — skipping frontend build. Ensure /public/build exists or install Node.js on the server." >&2
fi

php artisan migrate --force

php artisan config:cache
php artisan route:cache
php artisan view:cache

php artisan queue:restart 2>/dev/null || true

echo "==> Deploy finished OK"
