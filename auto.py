from telethon import TelegramClient, events

# اطلاعات حساب کاربری تلگرام خود را وارد کنید
api_id = '28136668'
api_hash = 'caf312f10b96ca02cc1a47352bfe0ddb'
phone_number = '+989215206591'

# ایجاد یک کلاینت تلگرام
client = TelegramClient('session_name', api_id, api_hash)

@client.on(events.NewMessage)
async def handler(event):
    # بررسی اینکه پیام از یک چت خصوصی است
    if event.is_private:
        # ارسال پیام خودکار به کاربر
        await event.respond('سلام! بعد از آنلاین شدن پاسخگوی شما خواهم بود.')

async def main():
    # اتصال به حساب کاربری
    await client.start(phone=phone_number)
    print("Client Created")
    # منتظر ماندن برای دریافت پیام‌ها
    await client.run_until_disconnected()

# اجرای برنامه
client.loop.run_until_complete(main())
