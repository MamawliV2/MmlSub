#!/bin/bash

# نصب پیش‌نیازها
pip install selenium telethon

# دریافت شماره تلفن از کاربر
read -p "Please enter your phone number: " phone_number

# ایجاد یک فایل پایتون موقت برای اجرای کد
cat << EOF > temp_script.py
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from telethon import TelegramClient
import time

options = webdriver.ChromeOptions()
options.add_argument('--headless')
driver = webdriver.Chrome(options=options)

driver.get('https://my.telegram.org/auth')

phone_input = driver.find_element(By.NAME, 'phone')
phone_input.send_keys("$phone_number")
driver.find_element(By.CSS_SELECTOR, 'button[type="submit"]').click()

code = input("Please enter the confirmation code sent to your phone: ")
code_input = driver.find_element(By.NAME, 'phone_code')
code_input.send_keys(code)
driver.find_element(By.CSS_SELECTOR, 'button[type="submit"]').click()

WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.LINK_TEXT, 'API development tools')))
driver.find_element(By.LINK_TEXT, 'API development tools').click()

api_id = driver.find_element(By.CSS_SELECTOR, 'span[data-id="app_id"]').text
api_hash = driver.find_element(By.CSS_SELECTOR, 'span[data-id="app_hash"]').text

print(f"Your API ID: {api_id}")
print(f"Your API Hash: {api_hash}")

driver.quit()
EOF

# اجرای فایل پایتون
python3 temp_script.py

# حذف فایل پایتون موقت پس از اجرا
rm temp_script.py
