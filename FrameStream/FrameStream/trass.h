/** Arduino, ESP32, C/C++ ***************************************** trass.h ***
 * 
 *                      Объявить/проинициализировать общепрограммные переменные
 *                                                     
 * v1.0.1, 17.02.2026                                 Автор:      Труфанов В.Е.
 * Copyright © 2026 tve                               Дата создания: 24.01.2026
**/

#pragma once   

#include "FS.h"

//#define isSAYALL true // разрешить вывод всех сообщений
#define isSAYMEM true // разрешить трассировку только состояния памяти
#define isSAYLOG true // вести файл ошибок дублированием сообщений

File logfile;  // дескриптор файла информационных сообщений и об ошибках

//   Variadic - макросы с переменным числом аргументов в #include <stdio.h> напоминают 
// собой функции и могут содержать переменное число аргументов.
//   Чтобы использовать макросы variadic, многоточие может быть указано в качестве 
// окончательного формального аргумента в определении макроса, а идентификатор замены 
// __VA_ARGS__ может использоваться в определении для вставки дополнительных аргументов.
// __VA_ARGS__ заменяется всеми аргументами, которые соответствуют многоточию, 
// включая запятые между ними.
//   Стандарт C указывает, что не менее одного аргумента необходимо передать в многоточие, 
// чтобы макрос не разрешал выражение с запятой. Традиционная реализация Microsoft C++ 
// подавляет конечную запятую, если аргументы не передаются в многоточие

#define sayf(format, ...) \
  { \
    char buffer[256]; \
    snprintf(buffer, sizeof(buffer), format, ##__VA_ARGS__); \
    Serial.print(buffer); \
    if (logfile && isSAYLOG) { \
      logfile.print(buffer); \
    } \
  }

#define sayfln(format, ...) \
  { \
    char buffer[256]; \
    snprintf(buffer, sizeof(buffer), format, ##__VA_ARGS__); \
    Serial.println(buffer); \
    if (logfile && isSAYLOG) { \
      logfile.println(buffer); \
    } \
  }

void say(char* buffer) {} 
void sayln(char* buffer) {} 

void say(char* buffer, String s) {} 
void sayln(char* buffer, String s) {} 

void say(char* buffer, unsigned int n, const char* s) {} 
void sayln(char* buffer, unsigned int n, const char* s) {} 

void say(char* buffer, uint64_t cardSize) {} 
void sayln(char* buffer, uint64_t cardSize) {} 
void sayln(char* buffer, const char* s) {} 

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
