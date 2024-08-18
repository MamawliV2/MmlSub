#!/bin/bash

# نصب پیش‌نیازها
apt update
apt install -y wget

# دریافت و نصب File Browser
wget -qO- https://filebrowser.org/install.sh | bash

# دریافت ورودی‌های کاربر
read -p "نام کاربری: " username
read -sp "رمز عبور: " password
echo
read -p "پورت: " port

# ایجاد کاربر و تنظیمات اولیه
filebrowser users add $username $password --perm.admin
filebrowser config set --address 0.0.0.0 --port $port

# راه‌اندازی File Browser
filebrowser -r /path/to/your/files

echo "نصب و راه‌اندازی با موفقیت انجام شد. برای دسترسی به پنل به آدرس http://your_server_ip:$port مراجعه کنید."
