import requests
import time
url = "http://www.quhechacn.com/api/app/getaccesslog"
while True:
    num = input()
    if num:
        print()
        print()
        print()
    param = {
        "num":num
    }
    result = requests.get(url,params=param).json()
    print("      调用时间     ", "    调用者     ", "   账号  ", "          资源           ",   "   method请求方式    ")
    for line in result['result']:
        print()
        print()
        print(
            time.strftime('%Y-%m-%d-%H-%I-%S',time.localtime(line['access_time'])),
            '---',
            line['username'],
            '---',
            line['mobile'],
            '---',
            line['url'],
            '---',
            line['method'],
            '---',
        )
        print("--请求体--")
        print(line['data'])

