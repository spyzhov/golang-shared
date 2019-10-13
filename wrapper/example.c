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
/////////////////////////////////////////////////
double  My_variable  = 3.0;

/* Compute factorial of n */
int fact(int n) {
  if (n <= 1)
    return 1;
  else
    return n*fact(n-1);
}

/* Compute n mod m */
int my_mod(int n, int m) {
  return(n % m);
}