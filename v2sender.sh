#!/bin/bash

# توکن ربات خود را اینجا قرار دهید
BOT_TOKEN="7040822162:AAGUrdK9YlQozSzGUExITTbFJ60b8LF5eT8"
# آیدی کانال مقصد را اینجا قرار دهید
CHAT_ID="@My_SaveMessage"
# آیدی کانال منبع را اینجا قرار دهید
SOURCE_CHAT_ID="@ConfigsHUB2"

# تابع ارسال پیام
send_message() {
    local message=$1
    curl -s -X POST "https://api.telegram.org/bot$BOT_TOKEN/sendMessage" -d chat_id=$CHAT_ID -d text="$message"
}

# دریافت پیام‌ها از کانال منبع
get_messages() {
    local last_message_id=$(curl -s "https://api.telegram.org/bot$BOT_TOKEN/getUpdates" | jq '.result[-1].message.message_id')
    local new_messages=$(curl -s "https://api.telegram.org/bot$BOT_TOKEN/getUpdates?offset=$((last_message_id + 1))")

    echo $new_messages | jq -c '.result[]? | select(.message.chat.username == "'$SOURCE_CHAT_ID'") | .message.text' | while read message; do
        send_message "$message"
        log_result "$message"
    done
}

# تابع ثبت نتیجه در سرور
log_result() {
    local message=$1
    echo "Message sent: $message" >> /path/to/logfile.log
}

# اجرای تابع دریافت پیام‌ها
get_messages
