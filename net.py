from telethon import TelegramClient, events
import asyncio

# اطلاعات حساب کاربری تلگرام خود را وارد کنید
api_id = '1416439'
api_hash = '9ac5952633a05e37c246a9ce5b93b5b1'
phone_number = '+989944308487'

# ایجاد یک کلاینت تلگرام
client = TelegramClient('session_name', api_id, api_hash)

async def main():
    # اتصال به حساب کاربری
    await client.start(phone=phone_number)
    print("Client Created and Online")

    # نگه داشتن کلاینت آنلاین
    while True:
        await asyncio.sleep(60)  # هر 60 ثانیه یکبار منتظر می‌ماند تا آنلاین بماند

# اجرای برنامه
client.loop.run_until_complete(main())
