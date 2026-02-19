/** Arduino, ESP32, C/C++ **************************************** inimem.h ***
 * 
 * FrameStream - объявить/проинициализировать общепрограммные переменные
 *                                                     
 * v1.0.6, 17.02.2026                                 Автор:      Труфанов В.Е.
 * Copyright © 2026 tve                               Дата создания: 24.01.2026
**/

#pragma once   

#define idctrl   205                           // идентификатор контроллера
#define namectrl "Esp32-CAM на дорогу к даче"  // тип контроллера и место размещения

/*
#include "time.h"
#include "FS.h"
#include <SD_MMC.h>

// Объявляем дескрипторы файлов
File avifile;  // файл потока графических изображений (кадров)
File idxfile;  // файл указателей кадров

static const char _hsoftIP[] ="IP-адрес своей сети контроллера - http://";
static const char _hlocalIP[]="IP-адрес в локальной сети       - http://";
const word filemanagerport=8080;       // порт файлового менеджера
char localip[20];                      // IP-адрес локальной сети
char softip[20];                       // IP-адрес собственной сети контроллера
bool found_router = false;             // true - определена локальная сеть

time_t now;
struct tm timeinfo;

TaskHandle_t the_camera_loop_task;
TaskHandle_t the_streaming_loop_task;
SemaphoreHandle_t baton;

bool restart_now = false;   // true - начать запись нового avi-видео
bool reboot_now = false;    // true - завершить запись и перезагрузить контроллер
bool web_stop = false;      // true - завершить запись для OTA или по команде Stop из браузера

#define Lots_of_Stats true  // true - выводить статистику состояний
#define blinking 0
*/

int framesizeconfig;        //
int qualityconfig;          //
int buffersconfig;          // количество отдельных буферов для кадров

/*
// Буфер для 4 кадров, в соответствии с [config.h].cbuffersconfig = 4,
// первоначально сформированный и загруженный при инициировании камеры
int frame_buffer_size;      // буфер для 4 кадров

bool do_the_reindex = false;
//bool done_the_reparse = false;
bool done_the_reindex = false;

char file_to_edit[50] = "/JamCam0481.0007.avi"; //61.3

#define BUFFSIZE 512
uint8_t buf[BUFFSIZE];

long avi_start_time = 0;   // время начала видео-записи
long avi_end_time = 0;
char avi_file_name[100];   // название записываемого файла *.avi
uint16_t frame_cnt = 0;    // общее количество кадров в файле
*/

// *************************************************************** inimem.h ***
