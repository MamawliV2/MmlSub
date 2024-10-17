import asyncio
from telethon import TelegramClient, events

# درخواست دریافت API ID و API Hash از کاربر
api_id = input("لطفاً API ID خود را وارد کنید: ")
api_hash = input("لطفاً API Hash خود را وارد کنید: ")

# درخواست دریافت شناسه کانال برای ارسال پیام
channel_username = input("لطفاً نام کاربری (username) کانال را وارد کنید (با @): ")

# ساخت کلاینت تلگرام
client = TelegramClient('session_name', api_id, api_hash)

# پیام پیش فرض
default_message = "صبور باشید، در اسرع وقت پاسخگو هستم."

# متغیر برای فعال/غیرفعال کردن پاسخ خودکار و نگه داشتن حساب آنلاین
auto_reply_enabled = False
keep_alive_enabled = False

# تابع برای نگه داشتن حساب آنلاین و ارسال پیام به کانال هر 10 ثانیه
async def keep_alive():
    global keep_alive_enabled
    while keep_alive_enabled:
        try:
            await client.send_message(channel_username, "حساب آنلاین است")
            print("پیام ارسال شد.")
        except Exception as e:
            print(f"خطا در ارسال پیام: {e}")
        await asyncio.sleep(10)  # هر 10 ثانیه یک‌بار

# زمانی که پیام جدیدی دریافت می‌شود
@client.on(events.NewMessage(incoming=True))
async def handle_private_message(event):
    global auto_reply_enabled
    global default_message
    global keep_alive_enabled

    # بررسی دستورات برای شروع، توقف و تغییر پیام پیش‌فرض
    if event.raw_text == '.estart':
        auto_reply_enabled = True
        await event.respond("پاسخ خودکار فعال شد.")
        return

    if event.raw_text == '.estop':
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

    # دستور .keepalive برای نگه داشتن حساب آنلاین
    if event.raw_text == '.keepalive':
        keep_alive_enabled = True
        await event.respond(f"حساب شما به‌طور مداوم آنلاین خواهد بود و پیام‌ها به کانال {channel_username} ارسال می‌شوند.")
        # شروع تابع برای ارسال پیام و نگه داشتن حساب آنلاین
        await keep_alive()
        return

    # دستور .stopkeep برای غیرفعال کردن نگه داشتن حساب آنلاین
    if event.raw_text == '.stopkeep':
        keep_alive_enabled = False
        await event.respond("حساب شما دیگر آنلاین نخواهد بود.")
        return

    # اگر پاسخ خودکار فعال است، به پیام خصوصی کاربر پاسخ داده شود
    if event.is_private and auto_reply_enabled:
        # ارسال پیام پیش فرض
        await event.respond(default_message)

# شروع کلاینت و درخواست شماره تلفن
with client:
    print("لطفاً شماره تلفن حساب تلگرام خود را وارد کنید تا وارد شوید.")
    client.start()  # این خط شماره تلفن را درخواست می‌کند و کد تأیید را دریافت می‌کند
    print("ربات فعال است...")
    client.run_until_disconnected()
