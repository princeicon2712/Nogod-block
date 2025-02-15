import requests

# Take user input for the phone number
msisdn = input("What is the phone number: ")

url = "https://app2.mynagad.com:20002/api/user/check-user-status-for-log-in"

headers = {
  'Host': "app2.mynagad.com:20002",
  'User-Agent': "python-requests/2.32.3",
  'Accept-Encoding': "gzip, deflate",
  'X-KM-User-AspId': "100012345612345",
  'X-KM-User-Agent': "ANDROID/1164",
  'X-KM-DEVICE-FGP': "19DC58E052A91F5B2EB59399AABB2B898CA68CFE780878C0DB69EAAB0553C3C6",
  'X-KM-Accept-language': "bn",
  'X-KM-AppCode': "01",
  'Cookie': "WMONID=5CAH7XktVV4; TS01e66e4e=01e006cfdc29d1185d704d9b179b42be27a93ee6d8191ee45d9036e01aaf36e66113655c518d30d9b55fe131447b4ac04ee0894a78d8921b9a11ef69e25990df882ff3080f"
}

# Loop to run the request 6 times
for i in range(6):
    print(f"Request #{i + 1}")
    params = {
        'msisdn': msisdn  # Use the user-provided phone number
    }
    response = requests.get(url, params=params, headers=headers)
    print(response.text)
    print("-" * 40)  # Separator for better readability

