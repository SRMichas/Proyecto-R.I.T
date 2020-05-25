#include <ESP8266HTTPClient.h>
#include <ESP8266WiFi.h>
#include <ArduinoJson.h>

const char* ssid = "UbeeD3C5";
const char* password = "RandomAccesTaco28";
const int maquina = 1;
String codigo;
String conteo = "";

void setup() {
  Serial.begin(9600);
  WiFi.begin(ssid, password);

  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
  }
}

void loop() {
  esperarArduino();
}

void esperarArduino() {
  conteo = "";
  while (conteo.equals("")) {
    if (Serial.available())
      conteo = Serial.readString();
  }
  if (!conteo.equals("")) {
//    Serial.println("Entró a if. Conteo: " + conteo);
    conexion();
    Serial.print(codigo);
  }
}

void conexion() {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    http.begin("http://9d12bc4d.ngrok.io/api/cadena");
    http.addHeader("Content-Type", "application/json");
    String payload = "{\"conteo\": \"" + conteo + "\", \"maquina\": \"" + maquina + "\"}";
//    Serial.println("Se envía: " + payload);
    int httpCode = http.POST(payload);
    if (httpCode > 0) {
      String recepcion = http.getString();
//      Serial.println("Se recibe: " + recepcion);
      char json[recepcion.length() + 1];
      recepcion.toCharArray(json, recepcion.length());
//      Serial.print("JSON: ");
//      Serial.println(json);
      parserJson(json);
    } else {
      codigo = "error...";
    }
    http.end();
  }
}

void parserJson(char* json) {
  DynamicJsonDocument documento(1024);
  deserializeJson(documento, json);
  String auxiliar = documento["Codigo"];
  codigo = auxiliar;
  //  Serial.println("Código tras el parser: " + codigo);
}
