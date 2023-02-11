#include <ESP8266WiFi.h>

#include <ESP8266HTTPClient.h> // knggo akses ssl pk yg WiFiClientSecure

#include <WiFiClient.h>

const char *ssid = "Boys 359";
const char *password = "1jam2000an";

String value = "";
int checkConn = 1;

HTTPClient http;
WiFiClient wifiClient;

void connect();

void setup()
{
  Serial.begin(115200);

  if (WiFi.status() != WL_CONNECTED)
  {
    connect();
  }
}

void connect()
{
  if (WiFi.status() != WL_CONNECTED)
  {
    while (WiFi.status() != WL_CONNECTED)
    {
      WiFi.begin(ssid, password);
      Serial.println("Connecting...");
      delay(5000);
    }
  }
}

void loop()
{
  if(checkConn == 0 && WiFi.status() == WL_CONNECTED) {
    Serial.println("Connected");
    checkConn = 1;
  }

  if (Serial.available() > 0)
  {
    delay(500);

    value = Serial.readString();

    if (value[0] == '*')
    {
      String URL = "http://192.168.100.206:8080/api/esp";

      http.begin(wifiClient, URL);
      http.addHeader("Content-Type", "x-www-form-urlencoded");
      http.addHeader("Accept", "application/json");

      http.POST(value);

      http.end();
      Serial.println("ESP : SENDED | ");
      Serial.print(value);
    }
  }
}