/* File : example.i */
%module example
%{
extern int   print_image_size(char *path);
extern void  http_serve(int port);
extern char* json_path(char* path, char* json, char *err);
%}

extern int   print_image_size(char *path);
extern void  http_serve(int port);
extern char* json_path(char* path, char* json, char *err);
