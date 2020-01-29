#include <stdio.h>
#include <string.h>
#include <stdlib.h>

#include "libgolangutil.h"

int print_image_size(char *path) {
    char *err;
    GoUint w, h;

    err = GetImageSize(path, &w, &h);

    if (err != NULL) {
        fprintf(stderr, "error: %s\n", err);
        free(err);
        return 1;
    }

    printf("%s: %llux%llu\n", path, w, h);

    return 0;
}

void http_serve(int port) {
    HttpServe(port);
}

char* json_path(char* path, char* json, char *err) {
    return JSONPath(path, json, &err);
}
