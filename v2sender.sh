#!/bin/bash

# دریافت توکن ربات و شناسه‌های کانال‌ها از کاربر
read -p "لطفاً توکن ربات خود را وارد کنید: " BOT_TOKEN
read -p "لطفاً شناسه کانال منبع را وارد کنید: " SOURCE_CHANNEL_ID
read -p "لطفاً شناسه کانال مقصد را وارد کنید: " DEST_CHANNEL_ID

# دریافت پیام‌های کانال منبع
messages=$(curl -s "https://api.telegram.org/bot$BOT_TOKEN/getUpdates" | jq -r '.result[] | select(.message.chat.id == '$SOURCE_CHANNEL_ID') | .message.text')

# پردازش پیام‌ها و استخراج کانفیگ‌های V2ray
for message in $messages; do
    if [[ $message == *"vmess://"* ]] || [[ $message == *"vless://"* ]]; then
        # ارسال کانفیگ به کانال مقصد
        curl -s -X POST "https://api.telegram.org/bot$BOT_TOKEN/sendMessage" -d "chat_id=$DEST_CHANNEL_ID&text=$message"
    fi
done

# نمایش پیام نصب موفقیت‌آمیز
echo "نصب موفقیت‌آمیز بود!"
