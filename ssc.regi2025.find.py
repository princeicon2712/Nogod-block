import requests

url = "http://www.educationboardresults.gov.bd/result.php"

roll = input("What is the roll number? : ")
reg_start = int(input("Start reg number: "))
reg_end = int(input("End reg number: "))

for reg in range(reg_start, reg_end + 1):
    payload = {
        'sr': '1',
        'et': '2',
        'exam': 'ssc',
        'year': '2025',
        'board': 'sylhet',
        'roll': roll,
        'reg': str(reg),
        'value_a': '2',      # Captcha fixed as example: 2 + 7 = 9
        'value_b': '7',
        'value_s': '9'
    }

    headers = {
        'User-Agent': "Mozilla/5.0 (Linux; Android 13; 23027RAD4I Build/TKQ1.221114.001) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.7151.117 Mobile Safari/537.36",
        'Accept-Encoding': "gzip, deflate",
        'X-Requested-With': "XMLHttpRequest",
        'Origin': "http://www.educationboardresults.gov.bd",
        'Referer': "http://www.educationboardresults.gov.bd/",
        'Accept-Language': "en-US,en;q=0.9"
    }

    response = requests.post(url, data=payload, headers=headers)

    if "GPA" in response.text or "grade" in response.text.lower():
        print(f"✅ Result found for Reg: {reg}")
        print(response.text)
        break  # result পেলে আর চেক না করে বের হয়ে যাবে
    else:
        print(f"❌ No result for Reg: {reg}")
