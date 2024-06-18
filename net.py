import requests
import random
import string
import json

host = "shop2.proxylink.xyz"

def generate_random_alpha_string(length=6):
    letters = string.ascii_letters
    return ''.join(random.choices(letters, k=length))

email = f"{generate_random_alpha_string()}@gmail.com"

register_url = 'https://shop2.proxylink.xyz/api/v1/passport/auth/register'
login_url = 'https://shop2.proxylink.xyz/api/v1/passport/auth/login'
order_save_url = 'https://shop2.proxylink.xyz/api/v1/user/order/save'
checkout_url = 'https://shop2.proxylink.xyz/api/v1/user/order/checkout'

register_data = {
    'email': email,
    'password': 'a123123123',
    'invite_code': '',
    'email_code': ''
}

register_response = requests.post(register_url, data=register_data, verify=True)
if register_response.status_code == 200:
    register_json = register_response.json()
    if register_json.get('data'):
        auth_data = register_json['data'].get('auth_data')
        if auth_data:
            login_data = {
                'email': email,
                'password': 'a123123123'
            }
            headers = {
                'authorization': f'{auth_data}',
                'Referer': 'https://shop2.proxylink.xyz/',
                'Host': 'shop2.proxylink.xyz'
            }
            login_response = requests.post(login_url, data=login_data, headers=headers, verify=True)
            if login_response.status_code == 200:
                login_json = login_response.json()
                if login_json.get('data'):
                    auth_data = login_json['data'].get('auth_data')
                    token = login_json['data'].get('token')
                    if auth_data and token:
                        order_data = {
                            'period': 'month_price',
                            'plan_id': '6',
                            'coupon_code': '开业大吉'
                        }
                        order_response = requests.post(order_save_url, json=order_data, headers=headers, verify=True)
                        if order_response.status_code == 200:
                            order_json = order_response.json()
                            trade_no = order_json.get('data')
                            if trade_no:
                                checkout_data = {
                                    'trade_no': trade_no,
                                }
                                checkout_response = requests.post(checkout_url, data=checkout_data, headers=headers, verify=True)
                                if checkout_response.status_code == 200:
                                    checkout_json = checkout_response.json()
                                    checkout_data提取 = checkout_json.get('data', "")
                                    return_data = json.dumps({"data": checkout_data提取}, indent=4)
                                    subscription_link = "https://link5.proxylink.xyz/ease/link?token=" + token
                                    print(
                                        f"关注TG频道获取更多资源TG@MFJD666\n\n"

f"可用流量50GB 有效期30天\n\n"
                                        f"订阅地址:\n{subscription_link}"
                                    )
                                else:
                                    print(f'订单结算失败，状态码：{checkout_response.status_code}')
                            else:
                                print('无法提取订单号。')
                        else:
                            print(f'订单提交失败，状态码：{order_response.status_code}\n{order_response.text}')
                    else:
                        print('无法提取登录后的auth_data或token。')
                else:
                    print('登录响应中无data字段。')
            else:
                print(f'登录失败，状态码：{login_response.status_code}\n{login_response.text}')
        else:
            print('无法提取注册时的auth_data。')
    else:
        print('注册响应中无data字段。')
else:
    print(f'注册失败，状态码：{register_response.status_code}\n{register_response.text}')
