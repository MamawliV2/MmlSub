from flask import Flask, request, render_template_string
from telethon import TelegramClient
import asyncio

app = Flask(__name__)

html_form = '''
    <form method="post">
        API ID: <input type="text" name="api_id"><br>
        API Hash: <input type="text" name="api_hash"><br>
        Phone Number: <input type="text" name="phone_number"><br>
        Channel Username: <input type="text" name="channel_username"><br>
        <input type="submit" value="Submit">
    </form>
'''

@app.route('/', methods=['GET', 'POST'])
def index():
    if request.method == 'POST':
        api_id = request.form['api_id']
        api_hash = request.form['api_hash']
        phone_number = request.form['phone_number']
        channel_username = request.form['channel_username']

        client = TelegramClient('session_name', api_id, api_hash)

        async def main():
            await client.start(phone=phone_number)
            print("Client Created and Online")
            while True:
                await client.send_message(channel_username, 'Keeping the channel active')
                await asyncio.sleep(5)

        asyncio.run(main())
        return "Client Created and Online"
    return render_template_string(html_form)

if __name__ == '__main__':
    app.run(debug=True)
