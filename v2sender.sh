#!/bin/bash

# توکن ربات خود را اینجا قرار دهید
BOT_TOKEN="7032388315:AAFey4M3eiFkKgQtq6oDpESr6BgZoVTBMiE"
# آیدی کانال مقصد را اینجا قرار دهید
CHAT_ID="@My_SaveMessage"

# تابع ارسال پیام
send_message() {
    local message=$1
    curl -s -X POST "https://api.telegram.org/bot$BOT_TOKEN/sendMessage" -d chat_id=$CHAT_ID -d text="$message"
}

# دریافت پیام‌ها از کانال منبع
get_messages() {
    local source_chat_id="@v2ray_configs_pool"
    local last_message_id=$(curl -s "https://api.telegram.org/bot$BOT_TOKEN/getUpdates" | jq '.result[-1].message.message_id')
    local new_messages=$(curl -s "https://api.telegram.org/bot$BOT_TOKEN/getUpdates?offset=$((last_message_id + 1))")

    echo $new_messages | jq -c '.result[] | select(.message.chat.username == "'$source_chat_id'") | .message.text' | while read message; do
        send_message "$message"
    done
}

# اجرای تابع دریافت پیام‌ها
get_messages
