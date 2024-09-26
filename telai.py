from telethon import TelegramClient, events
import openai
import asyncio

# دریافت مقادیر از کاربر
api_id = input("لطفاً API ID خود را وارد کنید: ")
api_hash = input("لطفاً API Hash خود را وارد کنید: ")
openai_api_key = input("لطفاً OpenAI API Key خود را وارد کنید: ")

client = TelegramClient('session_name', api_id, api_hash)
openai.api_key = openai_api_key

running = False

@client.on(events.NewMessage(pattern=r'\.start'))
async def start_bot(event):
    global running
    running = True
    await event.reply('ربات فعال شد!')

@client.on(events.NewMessage(pattern=r'\.stop'))
async def stop_bot(event):
    global running
    running = False
    await event.reply('ربات غیر فعال شد!')

@client.on(events.NewMessage)
async def handler(event):
    global running
    if running and event.is_private:  # فقط پیام‌های خصوصی
        user_message = event.message.message
        response = openai.Completion.create(
            engine="text-davinci-003",
            prompt=user_message,
            max_tokens=150
        )
        reply = response.choices[0].text.strip()
        await event.reply(reply)

client.start()
client.run_until_disconnected()
