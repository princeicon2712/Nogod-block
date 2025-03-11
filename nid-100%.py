import requests

# Taking user input
nid = str(input("What is the NID No:-- "))
dob = str(input("What is the [YYYY-MM-DD] No:-- "))

url = "https://api.bdansarerp.gov.bd/api/check_nid_data/"

params = {
    'nid': nid,
    'dob': dob
}

headers = {
    'User-Agent': "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36",
    'Accept': "application/json, text/plain, */*",
    'Accept-Encoding': "gzip, deflate, br, zstd",
    'sec-ch-ua-platform': "\"Android\"",
    'sec-ch-ua': "\"Not(A:Brand\";v=\"99\", \"Android WebView\";v=\"133\", \"Chromium\";v=\"133\"",
    'sec-ch-ua-mobile': "?1",
    'Origin': "https://recruitment.bdansarerp.gov.bd",
    'X-Requested-With': "mark.via.gp",
    'Sec-Fetch-Site': "same-site",
    'Sec-Fetch-Mode': "cors",
    'Sec-Fetch-Dest': "empty",
    'Referer': "https://recruitment.bdansarerp.gov.bd/",
    'Accept-Language': "en-US,en;q=0.9",
    'Cookie': "connect.sid=s%3AhhM0Tc1KN6gwoLcyNvUXXO7JcR_pUQVw.cmJ9ODKNjQZu8339OM5HANn98K9Xej5SVr83uQsPnSI"
}

# Making the request
response = requests.get(url, params=params, headers=headers)

# Printing the response
print(response.text)
