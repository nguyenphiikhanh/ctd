echo "Cong Tac Doan - Dev Environment Deploying..."

echo "pulling from origin..."
git fetch --all && git reset --hard origin/CONGTACDOAN-deployment && git pull

echo "Database migrating..."
php artisan migrate

echo "production UI building..."
npm run prod

echo "optimzing..."
php artisan optimize:clear

echo "Changing Owner"
sudo chown -R nguyenphikhanh:nguyenphikhanh /www/wwwroot/congtacdoan-test-env.nguyenphikhanh.dev/
