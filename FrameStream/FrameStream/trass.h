/** Arduino, ESP32, C/C++ ***************************************** trass.h ***
 * 
 *                      Объявить/проинициализировать общепрограммные переменные
 *                                                     
 * v1.1.4, 21.02.2026                                 Автор:      Труфанов В.Е.
 * Copyright © 2026 tve                               Дата создания: 24.01.2026
**/

#pragma once   

#include "FS.h"

// Специальные сообщения - это сообщения по использованию памяти, по времени ... 
#define isSAYLOG true   // true - вести файл дублирования сообщений
bool isSAY=true;        // true - разрешить вывод неспециальных сообщений
bool isSAYMEM=true;     // true - разрешить трассировку состояния памяти

File logfile;           // дескриптор файла информационных сообщений и об ошибках
char buffer[256];       // буфер сообщения

// ****************************************************************************
// *       Собственно вывести буфер в последовательный порт и лог-файл        *
// ****************************************************************************
void _say(char* buf) 
{
  if (isSAY)
  {
    Serial.print(buf); 
    if (logfile && isSAYLOG) 
    { 
      logfile.print(buf);
    }
  } 
}
// ****************************************************************************
// *      Начать новую строку вывода в последовательный порт и лог-файл       *
// ****************************************************************************
void addln() 
{
  if (isSAY)
  {
    Serial.println(""); 
    if (logfile && isSAYLOG) 
    { 
      logfile.println(""); 
    } 
  }
} 

void say(char* format) 
{
  _say(format); 
} 
void sayln(char* format) {say(format); addln();}

void say(char* format, const char* s) 
{
  snprintf(buffer, sizeof(buffer), format, s); 
  _say(buffer); 
} 
void sayln(char* format, const char* s) {say(format,s); addln();}

void say(char* format, char* s) 
{
  snprintf(buffer, sizeof(buffer), format, s); 
  _say(buffer); 
} 
void sayln(char* format, char* s) {say(format,s); addln();}

void say(char* format, const char* s, uint64_t n) 
{
  snprintf(buffer, sizeof(buffer), format,s,n);
  _say(buffer); 
} 
void sayln(char* format, const char* s, uint64_t n) {say(format,s,n); addln();}

void say(char* format, String s) 
{
  snprintf(buffer, sizeof(buffer), format, s); 
  _say(buffer); 
} 
void sayln(char* format, String s) {say(format,s); addln();}

void say(char* format, unsigned int n, const char* s) 
{
  snprintf(buffer, sizeof(buffer), format, n, s); 
  _say(buffer); 
} 
void sayln(char* format, unsigned int n, const char* s) {say(format,n,s); addln();} 

void say(char* format, int n) 
{
  snprintf(buffer, sizeof(buffer), format, n); 
  _say(buffer); 
} 
void sayln(char* format, int n) {say(format,n); addln();}

void say(char* format, uint32_t n) 
{
  snprintf(buffer, sizeof(buffer), format, n); 
  _say(buffer); 
} 
void sayln(char* format, uint32_t n) {say(format,n); addln();}

void say(char* format, uint64_t n) 
{
  snprintf(buffer, sizeof(buffer), format, n); 
  _say(buffer); 
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
// *        Подсчитать число символов UTF-8 в последовательности char*        *
// * https://stackoverflow.com/questions/4063146/getting-the-actual-length-of-a-utf-8-encoded-stdstring
// ****************************************************************************
size_t utf8len(const char* str) 
{
  size_t len = 0;
  for (size_t i = 0; *str != 0; ++len) 
  {
    int v01 = ((*str & 0x80) >> 7) & ((*str & 0x40) >> 6);
    int v2 = (*str & 0x20) >> 5;
    int v3 = (*str & 0x10) >> 4;
    str += 1 + ((v01 << v2) | (v01 & v3));
  }
  return len;
}
// ****************************************************************************
// *              Показать состояние памяти с заданным префиксом              *
// ****************************************************************************
void saymem(char* text) 
{
  if (isSAYMEM)
  {
    // Запоминаем состояние разрешения на вывод сообщений
    bool oldSay=isSAY;       
    // Разрешаем вывод сообщений
    isSAY=true;      
    // Определяем наибольшее число символов текста вместе с пробелами
    // и дополняем текст пробелами слева 
    int nfill=48;   
    int j=nfill-utf8len(text)-2;
    for (int i = 0; i<j; i++) 
    {
      _say(" "); 
      /*
      Serial.print(" "); 
      if (logfile && isSAYLOG) 
      { 
        logfile.print(" "); 
      } 
      */
    }
    // Выводим специальное сообщение по памяти
    /**
     * xPortGetCoreID()        - функция возвращает номер ядра, на котором выполняется текущая задача
     * uxTaskPriorityGet(NULL) - возвращает приоритет текущей задачи (задачи, из которой была вызвана функция)
     * ESP.getFreeHeap()       - возвращает размер свободной кучи (heap) в байтах
     * ESP.getHeapSize()       - возвращает полный размер внутренней оперативной памяти в байтах (ОЗУ)
     * ESP.getFreePsram()      - свободный объём внешней оперативной памяти PSRAM
     * ESP.getPsramSize()      - полный объём внешней оперативной памяти PSRAM
    **/
    say("[%s]",text);
    say(" ядро: %d,",          int(xPortGetCoreID()));        say(" приоритет: %d, ", int(uxTaskPriorityGet(NULL)));
    say("свободная куча %6d ", uint32_t(ESP.getFreeHeap()));  say("от ОЗУ %6d, ",     uint32_t(ESP.getHeapSize()));
    say("FreePSRAM %6d ",      uint32_t(ESP.getFreePsram())); say("от FLASH %6d",     uint32_t(ESP.getPsramSize()));
    sayln(" ");
    // Восстанавливаем состояние разрешения на вывод сообщений
    isSAY=oldSay;      
  }
}

// **************************************************************** trass.h ***
