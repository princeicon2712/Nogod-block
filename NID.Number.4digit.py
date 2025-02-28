import requests
import json

# Taking user input
document_id = str(input("What is the NID [digit No]:-- "))
msisdn = str(input("What is the Phone No:-- "))

url = "https://myblapi.banglalink.net/api/profile/v1/sim-list"

payload = {
    "document_id": document_id
}

headers = {
    'User-Agent': "okhttp/5.0.0-alpha.10",
    'Connection': "Keep-Alive",
    'Accept': "application/json",
    'Accept-Encoding': "gzip",
    'Content-Type': "application/json",
    'Authorization': "Bearer eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCIsImtpZCI6Im15YmxfYmJ0bTNrTUlmdmoifQ.eyJhdWQiOiJteWJsYXBpLmJhbmdsYWxpbmsubmV0Iiwic3ViIjoiODgwMTk3NjQ0OTE2MyIsImN1c3RvbWVyX2lkIjoyNTUxOTUwODEsInBhY2thZ2VfaWQiOiIxIiwiaXNfZ3Vlc3QiOjAsImlzX2JsIjoxLCJqdGkiOiJhZDA4ZDJmOS03OTdjLTRkMDgtYjRkMC1lOGYzN2Q3MTQ1NjgiLCJ0eXAiOiJiZWFyZXIiLCJpYXQiOjE3NDA2NDQwMzgsIm5iZiI6MTc0MDY0NDAzOCwiZXhwIjoxNzQ4NDIwMDM4LCJpc3MiOiJpYW0uYmFuZ2xhbGluay5uZXQifQ.mQtARznWKN0swCddAWcDtG-EVAIBYwPbTHseq9jtU3TZNxUuOGonljoB8daQgKglYBCXyzMP8tJeYnOWz9qVl_KYANfgaibsY3Vxp0zseRvZbgfGGbc8WtSUbN0anIRN54HhGLeRr24S5W73GGGgxhkJCzpIjYt3fX5ymC4jZEoqECbmiCdRrJnIxmapYE08rRZnZpdgg1V9B8kRDI9yer8AUKIBVobrHFCPR-CzdFoxEuvhIWREhCpEs0iPMqztVNTtesntS_CSzBeOfn9s6546cttY_3QsUMBXQOu4SR6dg72f2Z0NyM2DLDPOGs1OLh2ddhfPjRlkPjacFgKPFfUl9j2ZzUqfBZW3l4rRX4Mf5wPxoOI-16Cmo_AtffazCBiekZJ0ms4v-WF1XhDKR-G7dvCXheZx76S93Qm5Foj-ETz7P9mAM5sZAV4o04idFogQJM-M-6TE9spjlnKwahG24_bebkRXVvoccamzwgU3gDENA4TECFUdl0t6KBefsjxtE_0gXRHup8DR6AoGJBdHHkQKxW-xVW6Dr7E8NqC3X__41ISEf9XIYCdK4eCbtuTSPAQVSdKgnykeJKiZOTtXP9oIAUSTwKge_U586GeqskMCJeMZMCDuAJAhODlfq3gGnz5dm1BySOkhdG-ns0nJIS4QLvlNmikb5GUJ0eo",
    'platform': "android",
    'Accept-Language': "en",
    'version-code': "1120002",
    'app-version': "11.20.2",
    'api-client-pass': "1E6F751EBCD16B4B719E76A34FBA9",
    'msisdn': msisdn,  # Using user input for phone number
    'connection-type': "PREPAID",
    'customer-type': "bl",
    'X-Device-Info': "Xiaomi,23027RAD4I,13",
    'X-Device-ID': "032b0d2e-3d10-7c15-54e3-7cbc6eecbf26",
    'X-Entitlements': "PREPAID,BG:508,BG:514,BG:515,BG:222,BG:233,BG:244,BG:236,BG:238,BG:240,BG:256,BG:292,BG:302,BG:327,BG:391,BG:407,BG:428",
    'Content-Type': "application/json; charset=UTF-8",
    'Cookie': "TS01d73811=01e808c47361120dc8c1744356638f529c43cf8ba405967882d11aafe14a5db561997f56a97f9f08f94a47141b1a0610e2421af8f7"
}

response = requests.post(url, data=json.dumps(payload), headers=headers)

print(response.text)
