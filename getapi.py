from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import random
import string

# تنظیمات مرورگر
options = webdriver.ChromeOptions()
options.add_argument('--headless')  # اجرای مرورگر به صورت مخفی
driver = webdriver.Chrome(options=options)

# باز کردن سایت تلگرام
driver.get('https://my.telegram.org/auth')

# وارد کردن شماره تلفن
phone_number = input("شماره تلفن خود را وارد کنید: ")
phone_input = driver.find_element(By.NAME, 'phone')
phone_input.send_keys(phone_number)

# کلیک روی دکمه 'Next'
next_button = driver.find_element(By.CSS_SELECTOR, 'button[type="submit"]')
next_button.click()

# منتظر ماندن برای وارد کردن کد تایید
code = input("کد تایید را وارد کنید: ")
code_input = WebDriverWait(driver, 10).until(
    EC.presence_of_element_located((By.NAME, 'phone_code'))
)
code_input.send_keys(code)

# کلیک روی دکمه 'Sign In'
sign_in_button = driver.find_element(By.CSS_SELECTOR, 'button[type="submit"]')
sign_in_button.click()

# باز کردن صفحه API
driver.get('https://my.telegram.org/apps')

# تولید رشته‌های تصادفی برای api_id و api_hash
app_title = ''.join(random.choices(string.ascii_letters, k=10))
short_name = ''.join(random.choices(string.ascii_letters, k=10))
url = 'https://example.com'
platform = 'Other'
description = 'This is a test app'

# پر کردن فرم
driver.find_element(By.NAME, 'app_title').send_keys(app_title)
driver.find_element(By.NAME, 'app_shortname').send_keys(short_name)
driver.find_element(By.NAME, 'app_url').send_keys(url)
driver.find_element(By.NAME, 'app_platform').send_keys(platform)
driver.find_element(By.NAME, 'app_desc').send_keys(description)

# کلیک روی دکمه 'Create Application'
create_button = driver.find_element(By.CSS_SELECTOR, 'button[type="submit"]')
create_button.click()

# دریافت api_id و api_hash
api_id = WebDriverWait(driver, 10).until(
    EC.presence_of_element_located((By.XPATH, '//span[@class="api_id"]'))
).text
api_hash = driver.find_element(By.XPATH, '//span[@class="api_hash"]').text

print(f"API ID: {api_id}")
print(f"API Hash: {api_hash}")

driver.quit()
