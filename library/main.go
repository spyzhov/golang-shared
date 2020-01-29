package main

import (
	"C"
	"encoding/json"
	"github.com/spyzhov/ajson"
	"image"
	_ "image/jpeg"
	_ "image/png"
	"log"
	"net/http"
	"os"
	"strconv"
	"time"
)

//export GetImageSize
func GetImageSize(path *C.char, w *uint, h *uint) *C.char {
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

//export HttpServe
func HttpServe(port int) {
	go func() {
		log.Printf("start http to listen on port :%d", port)
		http.DefaultServeMux.HandleFunc("/management/health", func(w http.ResponseWriter, r *http.Request) {
			defer r.Body.Close()
			log.Println("got request", r.Method, r.URL.String())

			status := 200
			info := map[string]string{
				"service": "golang_example",
				"time":    time.Now().String(),
			}
			w.Header().Set("Content-Type", "application/json")
			w.WriteHeader(status)
			if err := json.NewEncoder(w).Encode(info); err != nil {
				log.Println("error on write response", err)
			}
		})
		log.Fatal("ListenAndServe stops", http.ListenAndServe(":"+strconv.Itoa(port), nil))
	}()
}

//export JSONPath
func JSONPath(path *C.char, jsonString *C.char, error **C.char) *C.char {
	parts, err := ajson.JSONPath([]byte(C.GoString(jsonString)), C.GoString(path))
	if err != nil {
		*error = C.CString(err.Error())
		return nil
	}

	result := "["
	for i, part := range parts {
		if i != 0 {
			result += ","
		}
		result += string(part.Source())
	}
	result += "]"

	return C.CString(result)
}

func main() {}
