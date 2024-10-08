#!/bin/bash

# بررسی وجود curl
if ! command -v curl &> /dev/null; then
    echo "curl is not installed. Installing..."
    sudo apt-get update
    sudo apt-get install -y curl
fi

# درخواست توکن از کاربر
read -p "Enter your Telegram Bot Token: " bot_token

# درخواست چت آیدی از کاربر
read -p "Enter your Telegram Chat ID: " chat_id

# ایجاد پوشه برای اسکریپت
mkdir -p ~/telegram_time_script
cd ~/telegram_time_script

# نوشتن اسکریپت اصلی
cat << EOF > telegram_time_script.sh
#!/bin/bash

# تابع برای ارسال پیام به ربات تلگرام
send_message() {
    local token="\$1"
    local chat_id="\$2"
    local text="\$3"
    local url_req="https://api.telegram.org/bot\${token}/sendMessage?chat_id=\${chat_id}&text=\${text}"
    curl -s "\$url_req" > /dev/null
}

# تابع برای دریافت و ارسال زمان و تاریخ
send_time() {
    local token="\$1"
    local chat_id="\$2"
    current_datetime=\$(TZ="Asia/Tehran" date +'%a %b %e %Y%n%I:%M %p')
    persian_date=\$(date -d "\$(TZ="Asia/Tehran" date +'%Y-%m-%d')" +'%Y-%m-%d %H:%M:%S' | awk -F' ' '{print \$1}' | tr '-' '/')

    send_message "\$token" "\$chat_id" "🕰️ ساعت و تاریخ میلادی: \${current_datetime}\n📅 تاریخ شمسی: \${persian_date}"
}

# گوش دادن به ورودی کاربر
while true; do
    read -p "Enter command: " command
    if [[ "\$command" == "/time" ]]; then
        send_time "\$bot_token" "\$chat_id"
    else
        echo "Unknown command: \$command"
    fi
done
EOF

# تغییر مجوز فایل برای اجرایی شدن
chmod +x telegram_time_script.sh

# اجرای اسکریپت اصلی
./telegram_time_script.sh "$bot_token" "$chat_id"

echo "Installation completed. The script is now running."