#include <WiFi.h>
#include <HTTPClient.h>
#include <OneWire.h>
#include <DallasTemperature.h>

const char* ssid = "Nicholas";
const char* password = "4000100Nicholas";

String botToken = "8591506162:AAHbFtDk5Kh5gZtYx8w-ZJ-tFRninXfpOI8";
String chatID = "eteczl_bot";

#define ONE_WIRE_BUS 5
OneWire oneWire(ONE_WIRE_BUS);
DallasTemperature sensors(&oneWire);

unsigned long tempoAnterior = 0;
const long intervaloLeitura = 3000;

int contadorLeituras = 0;

float tempMin = 20.0;
float tempMax = 30.0;

bool alertaAtivo = false;

void enviarTelegram(String mensagem) {
  HTTPClient http;
  String url = "https://api.telegram.org/bot" + botToken + "/sendMessage?chat_id=" + chatID + "&text=" + mensagem;
  http.begin(url);
  http.GET();
  http.end();
}

void setup() {
  Serial.begin(115200);
  sensors.begin();

  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
  }
}

void loop() {
  unsigned long tempoAtual = millis();

  if (tempoAtual - tempoAnterior >= intervaloLeitura) {
    tempoAnterior = tempoAtual;

    sensors.requestTemperatures();
    float temp = sensors.getTempCByIndex(0);

    contadorLeituras++;

    if (contadorLeituras >= 20) {
      contadorLeituras = 0;

      if ((temp > tempMax || temp < tempMin) && !alertaAtivo) {
        enviarTelegram("ALERTA: " + String(temp));
        alertaAtivo = true;
      }

      if ((temp <= tempMax && temp >= tempMin) && alertaAtivo) {
        enviarTelegram("NORMAL: " + String(temp));
        alertaAtivo = false;
      }
    }
  }
}