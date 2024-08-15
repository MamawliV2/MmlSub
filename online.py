from telethon import TelegramClient, events
import asyncio

# دریافت اطلاعات حساب کاربری از کاربر
api_id = input("Please enter your API ID: ")
api_hash = input("Please enter your API Hash: ")
phone_number = input("Please enter your phone number: ")

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
