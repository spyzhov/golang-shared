import ctypes


def imgutil(path: str) -> int:
    libimgutil = ctypes.cdll.LoadLibrary("libimgutil.so")
    libimgutil.ImgutilGetImageSize.restype = ctypes.c_char_p

    w = ctypes.c_ulonglong(0)
    h = ctypes.c_ulonglong(0)

    err = libimgutil.ImgutilGetImageSize(ctypes.c_char_p(path.encode()), ctypes.byref(w), ctypes.byref(h))

    if err is not None:
        print(f"Error: {err}")
        return 1

    print(f'{path}: {w.value}x{h.value}')
    return 0


if __name__ == '__main__':
    res = imgutil('icon_128.png')
    print(f'int({res})')
