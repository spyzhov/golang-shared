package main

import (
	"C"
	"image"
	_ "image/jpeg"
	_ "image/png"
	"os"
)

//export ImgutilGetImageSize
func ImgutilGetImageSize(path *C.char, w *int, h *int) *C.char {
	file, err := os.Open(C.GoString(path))
	if err != nil {
		return C.CString(err.Error())
	}
	defer file.Close()

	img, _, err := image.Decode(file)
	if err != nil {
		return C.CString(err.Error())
	}

	rect := img.Bounds()
	*w = int(rect.Dx())
	*h = int(rect.Dy())

	return nil
}

func main() {}
