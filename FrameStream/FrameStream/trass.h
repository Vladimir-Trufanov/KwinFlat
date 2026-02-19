/** Arduino, ESP32, C/C++ ***************************************** trass.h ***
 * 
 *                      Объявить/проинициализировать общепрограммные переменные
 *                                                     
 * v1.1.2, 19.02.2026                                 Автор:      Труфанов В.Е.
 * Copyright © 2026 tve                               Дата создания: 24.01.2026
**/

#pragma once   

#include "FS.h"

//#define isSAYALL true // разрешить вывод всех сообщений
#define isSAYMEM true   // разрешить трассировку только состояния памяти
#define isSAYLOG true   // вести файл ошибок дублированием сообщений

File logfile;           // дескриптор файла информационных сообщений и об ошибках
char buffer[256];       // буфер сообщения


void addln() 
{
  Serial.println(""); 
  if (logfile && isSAYLOG) 
  { 
    logfile.println(""); 
  } 
} 

void say(char* format) 
{
  Serial.print(format); 
  if (logfile && isSAYLOG) 
  { 
    logfile.print(format); 
  } 
} 
void sayln(char* format) {say(format); addln();}

void say(char* format, const char* s) 
{
  snprintf(buffer, sizeof(buffer), format, s); 
  Serial.print(buffer); 
  if (logfile && isSAYLOG) 
  { 
    logfile.print(buffer);
  } 
} 
void sayln(char* format, const char* s) {say(format,s); addln();}

void say(char* format, String s) 
{
  snprintf(buffer, sizeof(buffer), format, s); 
  Serial.print(buffer); 
  if (logfile && isSAYLOG) 
  { 
    logfile.print(buffer);
  } 
} 
void sayln(char* format, String s) {say(format,s); addln();}

void say(char* format, unsigned int n, const char* s) 
{
  snprintf(buffer, sizeof(buffer), format, n, s); 
  Serial.print(buffer); 
  if (logfile && isSAYLOG) 
  { 
    logfile.print(buffer);
  } 
} 
void sayln(char* format, unsigned int n, const char* s) {say(format,n,s); addln();} 

void say(char* format, uint64_t n) 
{
  snprintf(buffer, sizeof(buffer), format, n); 
  Serial.print(buffer); 
  if (logfile && isSAYLOG) 
  { 
    logfile.print(buffer);
  } 

} 
void sayln(char* format, uint64_t n) {say(format,n); addln();}

// ****************************************************************************
// *      Отмигать аварийную ситуацию контрольным светодиодом в 10 циклов     *
// *               в случае неудачной работы камеры или sd-карты              *
// ****************************************************************************
void blinkRestart() 
{
  for  (int i = 0;  i < 10; i++) 
  {                
    for (int j = 0; j < 3; j++) 
    {
      digitalWrite(33, LOW);   delay(150);
      digitalWrite(33, HIGH);  delay(150);
    }
    delay(1000);
    for (int j = 0; j < 3; j++) 
    {
      digitalWrite(33, LOW);  delay(500);
      digitalWrite(33, HIGH); delay(500);
    }
    delay(1000);
    sayln("Аварийная ситуация [%d/10], перезагрузка контроллера",i);
  }
  if (logfile) logfile.close();
  ESP.restart();
}
// ****************************************************************************
// *              Показать состояние памяти с заданным префиксом              *
// ****************************************************************************

/**
 * xPortGetCoreID()        - функция возвращает номер ядра, на котором выполняется текущая задача
 * uxTaskPriorityGet(NULL) - возвращает приоритет текущей задачи (задачи, из которой была вызвана функция)
 * ESP.getFreeHeap()       - возвращает размер свободной кучи (heap) в байтах
 * ESP.getHeapSize()       - возвращает полный размер внутренней оперативной памяти в байтах (ОЗУ)
 * ESP.getFreePsram()      - свободный объём внешней оперативной памяти PSRAM
 * ESP.getPsramSize()      - полный объём внешней оперативной памяти PSRAM
**/
void saymem(const char* text) 
{
  if (isSAYMEM)
  {
    /*
    say("[%s] ядро: %d, приоритет: %d, ", text, xPortGetCoreID(), uxTaskPriorityGet(NULL));
    say("свободная куча %6d от ОЗУ %6d, ", ESP.getFreeHeap(), ESP.getHeapSize());
    say("FreePSRAM %6d от FLASH %6d", ESP.getFreePsram(), ESP.getPsramSize());
    sayln(" ");
    */
  }
}

// **************************************************************** trass.h ***
