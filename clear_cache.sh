echo "He thong Ho tro diem ren luyen - Truong Dai hoc Su pham Ha Noi"
echo "Production building version..."

echo "pulling from origin..."
git fetch --all && git reset --hard origin/CONGTACDOAN-deployment && git pull

echo "Database migrating..."
php artisan migrate

echo "production bundle asset building..."
npm run prod

echo "optimizing..."
php artisan optimize:clear
