from telegram import Update
from telegram.ext import Updater, CommandHandler, CallbackContext
import datetime

# توکن ربات خود را اینجا قرار دهید
TOKEN = '6573552535:AAHp8jHkxAEe11Rk-CPCiw9H3xywQIad7qs'

def start(update: Update, context: CallbackContext) -> None:
    update.message.reply_text('سلام! برای دریافت ساعت آنلاین، دستور /time را وارد کنید.')

def send_time(update: Update, context: CallbackContext) -> None:
    current_time = datetime.datetime.now().strftime('%H:%M:%S')
    update.message.reply_text(f'ساعت آنلاین: {current_time}')

def main() -> None:
    updater = Updater(TOKEN)
    
    dispatcher = updater.dispatcher

    dispatcher.add_handler(CommandHandler("start", start))
    dispatcher.add_handler(CommandHandler("time", send_time))

    updater.start_polling()
    updater.idle()

if __name__ == '__main__':
    main()
