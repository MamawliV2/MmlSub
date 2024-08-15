from telethon import TelegramClient, events

# تنظیمات ربات
api_id = '1416439'  # api_id شما
api_hash = '9ac5952633a05e37c246a9ce5b93b5b1'  # api_hash شما
phone_number = '+989944308487'  # شماره تلفن شما

# ایجاد کلاینت تلگرام
client = TelegramClient('session_name', api_id, api_hash)

@client.on(events.NewMessage)
async def handler(event):
    # چاپ پیام‌های دریافتی
    print(f"پیام جدید: {event.message.message}")

async def main():
    await client.start(phone=phone_number)
    print("ربات شروع به کار کرد")
    await client.run_until_disconnected()

# اجرای ربات
client.loop.run_until_complete(main())
