#include <stdio.h>
#include <string.h>
#include <stdlib.h>

#include "libimgutil.h"

int imgutil(char *path) {
    char *err;
    GoUint w, h;

    err = ImgutilGetImageSize(path, &w, &h);

    if (err != NULL) {
        fprintf(stderr, "error: %s\n", err);
        free(err);
        return 1;
    }

    printf("%s: %llux%llu\n", path, w, h);

    return 0;
}
