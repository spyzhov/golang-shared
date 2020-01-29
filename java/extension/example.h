#ifndef EXAMPLE_H
#define EXAMPLE_H 1

#include "libgolangutil.h"
#include <jni.h>

jint Java_Main_printImageSize(JNIEnv *jenv, jclass obj, jstring path);
void Java_Main_httpServe(JNIEnv *jenv, jclass obj, jint port);
jstring Java_Main_JSONPath(JNIEnv *jenv, jclass obj, jstring jpath, jstring jjson);

#endif
