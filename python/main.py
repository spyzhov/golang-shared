import ctypes
import json
import time
import urllib.request
from pprint import pprint

golangutil = ctypes.cdll.LoadLibrary("libgolangutil.so")
golangutil.GetImageSize.restype = ctypes.c_char_p
golangutil.JSONPath.restype = ctypes.c_char_p


def print_image_size(path: str) -> int:
    w = ctypes.c_ulonglong(0)
    h = ctypes.c_ulonglong(0)

    err = golangutil.GetImageSize(ctypes.c_char_p(path.encode()), ctypes.byref(w), ctypes.byref(h))

    if err is not None:
        print(f"Error: {err}")
        return 1

    print(f'{path}: {w.value}x{h.value}')
    return 0


def http_serve(port: int) -> None:
    golangutil.HttpServe(ctypes.c_longlong(port))


def json_path(path: str, json_string: str):
    err = ctypes.c_char_p()
    result = golangutil.JSONPath(ctypes.c_char_p(path.encode()), ctypes.c_char_p(json_string.encode()),
                                 ctypes.byref(err))
    if err.value is not None:
        raise RuntimeError(f"Error: {err.value}")
    return json.loads(result.decode())


def url_get_contents(host, url):
    conn = http.client.HTTPConnection(host)
    conn.request("GET", url)
    res = conn.getresponse()
    data = res.read()
    conn.close()
    return data


if __name__ == '__main__':
    url = "http://localhost:8080/management/health"
    print("IMAGE_SIZE")
    print_image_size("example.png")

    print("HTTP_SERVE")
    http_serve(8080)
    time.sleep(200.0 / 1_000_000.0)
    with urllib.request.urlopen(url) as f:
        content = f.read().decode()
        print(f"Got from {url}:\n{content}")

        print("JSON_PATH")
        pprint(json_path("$.service", content))

    with open('example.json', 'r') as f:
        example = f.read()
        examples = {
            '$..author': 'all authors',
            '$.store..price': 'the price of everything in the store.',
            '$..book[(@.length-1)]': 'the last book in order.',
            '$..book[?(@.price<10)]': 'filter all books cheapier than 10',
        }
        print(f"For exampe: \n{example}\n")
        for key in examples:
            value = examples[key]
            print(f"\n\t{value}: {key}")
            pprint(json_path(key, example))
