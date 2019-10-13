package main

import (
	"C"
	"image"
	_ "image/jpeg"
	_ "image/png"
	"os"
)

const version = "v0.0.1"

//export Version
func Version() *C.char {
	return C.CString(version)
}

//export ImgutilGetImageSize
func ImgutilGetImageSize(path *C.char, w *uint, h *uint) *C.char {
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
	*w = uint(rect.Dx())
	*h = uint(rect.Dy())

	return nil
}

func main() {}
