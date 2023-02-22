echo "Cong Tac Doan - Production Environment Deploying..."

echo "pulling from origin..."
git fetch --all && git reset --hard origin/CONGTACDOAN-deployment && git pull

echo "Database migrating..."
php artisan migrate

echo "production UI building..."
npm run prod

echo "optimizing..."
php artisan optimize:clear

echo "Changing Owner"
sudo chown -R www:www /www/wwwroot/kltn.nguyenphikhanh.dev/
