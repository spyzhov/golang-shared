#include <stdlib.h>
#include "example.h"

static void fail(JNIEnv *jenv, const char *error_name) {
    jclass error_class = (*jenv)->FindClass(jenv, error_name);
    (*jenv)->ThrowNew(jenv, error_class, NULL);
}

jint Java_Main_printImageSize(JNIEnv *jenv, jclass obj, jstring jpath) {
	char *err;
	GoUint w, h;

    if (jpath == NULL) {
		fail(jenv, "java/lang/NullPointerException");
		return 1;
    }
	const char *path = (*jenv)->GetStringUTFChars(jenv, jpath, 0);

	err = GetImageSize((char *)path, &w, &h);

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

void Java_Main_httpServe(JNIEnv *jenv, jclass obj, jint port) {
    HttpServe((long long)port);
}

jstring Java_Main_JSONPath(JNIEnv *jenv, jclass obj, jstring jpath, jstring jjson) {
	char *err;
	GoUint w, h;

    if (jpath == NULL || jjson == NULL) {
		fail(jenv, "java/lang/NullPointerException");
		return NULL;
    }
	const char *path = (*jenv)->GetStringUTFChars(jenv, jpath, 0);
	const char *json = (*jenv)->GetStringUTFChars(jenv, jjson, 0);

	const char *result = JSONPath((char *)path, (char *)json, &err);

	if (err != NULL) {
    	(*jenv)->ReleaseStringUTFChars(jenv, jpath, path);
    	(*jenv)->ReleaseStringUTFChars(jenv, jjson, json);
		fprintf(stderr, "error: %s\n", err);
		free(err);
		fail(jenv, "java/lang/InternalError");
		return NULL;
	}

    (*jenv)->ReleaseStringUTFChars(jenv, jpath, path);
    (*jenv)->ReleaseStringUTFChars(jenv, jjson, json);

	return (*jenv)->NewStringUTF(jenv, result);
}
