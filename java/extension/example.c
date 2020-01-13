#include <stdlib.h>
#include "example.h"

static void fail(JNIEnv *jenv, const char *error_name) {
    jclass error_class = (*jenv)->FindClass(jenv, error_name);
    (*jenv)->ThrowNew(jenv, error_class, NULL);
}

jint Java_Main_imgutil(JNIEnv *jenv, jclass obj, jstring jpath) {
	char *err;
	GoUint w, h;

    if (jpath == NULL) {
		fail(jenv, "java/lang/NullPointerException");
		return 1;
    }
	const char *path = (*jenv)->GetStringUTFChars(jenv, jpath, 0);

	err = ImgutilGetImageSize((char *)path, &w, &h);

	if (err != NULL) {
    	(*jenv)->ReleaseStringUTFChars(jenv, jpath, path);
		fprintf(stderr, "error: %s\n", err);
		free(err);
		fail(jenv, "java/lang/InternalError");
		return 1;
	}

	printf("%s: %llux%llu\n", path, w, h);
    (*jenv)->ReleaseStringUTFChars(jenv, jpath, path);

	return 0;
}
