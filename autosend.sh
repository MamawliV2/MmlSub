#!/bin/bash

# نام فایل پایتون که قرار است ایجاد شود
PYTHON_FILE="autoreply.py"

# ایجاد فایل پایتون و نوشتن کد پایتون در آن
cat << 'EOF' > $PYTHON_FILE
from telethon import TelegramClient, events

# درخواست دریافت API ID و API Hash از کاربر
api_id = input("لطفاً API ID خود را وارد کنید: ")
api_hash = input("لطفاً API Hash خود را وارد کنید: ")

# درخواست دریافت شناسه عددی ادمین (ID ادمین)
admin_id = int(input("لطفاً ID عددی ادمین را وارد کنید: "))

# ساخت کلاینت تلگرام
client = TelegramClient('mmli', api_id, api_hash)

# پیام پیش فرض
default_message = "صبور باشید، در اسرع وقت پاسخگو هستم."

# متغیر برای فعال/غیرفعال کردن پاسخ خودکار
auto_reply_enabled = False

# زمانی که پیام جدیدی دریافت می‌شود
@client.on(events.NewMessage(incoming=True))
async def handle_private_message(event):
    global auto_reply_enabled
    global default_message

    # اگر فرستنده ادمین است، مجاز به استفاده از دستورات مدیریتی
    if event.sender_id == admin_id:
        if event.raw_text == '.start':
            auto_reply_enabled = True
            await event.respond("پاسخ خودکار فعال شد.")
            return

        if event.raw_text == '.stop':
            auto_reply_enabled = False
            await event.respond("پاسخ خودکار غیرفعال شد.")
            return

        # دستور .edit برای تغییر پیام پیش‌فرض
        if event.raw_text.startswith('.edit '):
            # جدا کردن پیام جدید از دستور
            new_message = event.raw_text[6:].strip()
            if new_message:
                default_message = new_message
                await event.respond(f"پیام پیش‌فرض تغییر کرد به: {default_message}")
            else:
                await event.respond("لطفاً یک پیام جدید برای تغییر وارد کنید.")
            return

    # اگر پاسخ خودکار فعال است و فرستنده ادمین نیست
    if event.is_private and auto_reply_enabled and event.sender_id != admin_id:
        # ارسال پیام پیش فرض برای کاربران غیر ادمین
        await event.respond(default_message)

# شروع کلاینت و درخواست شماره تلفن
with client:
    print("لطفاً شماره تلفن حساب تلگرام خود را وارد کنید تا وارد شوید.")
    client.start()  # این خط شماره تلفن را درخواست می‌کند و کد تأیید را دریافت می‌کند
    print("ربات فعال است...")
    client.run_until_disconnected()
EOF

# اجرای فایل پایتون
python3 $PYTHON_FILE
