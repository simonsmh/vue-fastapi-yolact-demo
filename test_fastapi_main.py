import base64
import requests
from io import BytesIO, StringIO
from PIL import Image
url = "http://127.0.0.1:8000/yolact"
image = "yolact/images/buoy (2138).png"
with open(image, 'rb') as f:
    files = {'file': f}
    r = requests.post(url, files=files)

img_file = BytesIO(base64.b64decode(r.json().get("img")))
with Image.open(img_file) as img:
    img.show()
