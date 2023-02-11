#include <LiquidCrystal_I2C.h>
#include <SoftwareSerial.h>
#include <Servo.h>

LiquidCrystal_I2C lcd(0x27, 16, 2);
SoftwareSerial mySerial(10, 11);

const String business_id = "c750e031-8669-4317-9d5f-c5556f11925d", machine_id = "0e9b8061-3c73-44d2-b804-eaf43404fc8c";

// Sensor 1
const int trig_1 = 2;
const int echo_1 = 3;
float distanceCM_1 = 0;
long duration1;

// Sensor 2
const int trig_2 = 4;
const int echo_2 = 5;
float distanceCM_2 = 0;
long duration2;

// Sensor 3
const int trig_3 = 6;
const int echo_3 = 7;
float distanceCM_3 = 0;
long duration3;

float car_1, car_2, car_3;
int place_1_before = 0, place_2_before = 0, place_3_before = 0;
int place_1_current = 0, place_2_current = 0, place_3_current = 0;
float Dist = 3.0;

const int parkiran = 3;
int total = 0, timer_cnt = 0, queue = parkiran;

//Servo
Servo servo1;
Servo servo2;

//Infrared
int entrance_gate = 8;
int exit_gate = 12;



void setup()
{
  Serial.begin(115200);
  mySerial.begin(115200);

  pinMode(trig_1, OUTPUT);
  pinMode(trig_2, OUTPUT);
  pinMode(trig_3, OUTPUT);
  pinMode(echo_1, INPUT);
  pinMode(echo_2, INPUT);
  pinMode(echo_3, INPUT);

  lcd.init();
  lcd.backlight();
  lcd.setCursor(0, 0);
  lcd.print("SELAMAT DATANG");
  lcd.setCursor(0, 1);
  lcd.print("DI E-PARKING");
  delay(5000);
  lcd.clear();

  pinMode(entrance_gate, INPUT);
  pinMode(exit_gate, INPUT);

  servo1.attach(13);
  servo2.attach(9);
}

void loop()
{
  total = 0;

  car_1 = sensor_1();
  car_2 = sensor_2();
  car_3 = sensor_3();

  Serial.println("======");
  Serial.println(car_1);
  Serial.println(car_2);
  Serial.println(car_3);
  Serial.println("======");

  lcd.setCursor(0, 0);
  lcd.print("CAR1:");
  if (car_1 <= Dist)
  {
    lcd.print("OK");
    place_1_current = 1;
    total += 1;
  }
  else
  {
    place_1_current = 0;
    lcd.print("NO");
  }

  lcd.setCursor(8, 0);
  lcd.print("CAR2:");
  if (car_2 <= Dist)
  {
    lcd.print("OK");
    place_2_current = 1;
    total += 1;
  }
  else
  {
    place_2_current = 0;
    lcd.print("NO");
  }

  lcd.setCursor(0, 1);
  lcd.print("CAR3:");
  if (car_3 <= Dist)
  {
    lcd.print("OK");
    place_3_current = 1;
    total += 1;
  }
  else
  {
    place_3_current = 0;
    lcd.print("NO");
  }

  lcd.setCursor(8, 1);
  lcd.print("ADA: ");
  lcd.print(queue);

  gates();

  if (timer_cnt >= 10) {
    if (place_1_before != place_1_current || place_2_before != place_2_current || place_3_before != place_3_current) {
      place_1_before = place_1_current;
      place_2_before = place_2_current;
      place_3_before = place_3_current;

      String param = "{'sender':'sensor','business_id':'" + business_id + "','machine_id':'" + machine_id + "','available':" + (3 - total) + ",'inside':" + total + ",'map':{'place_1':" + place_1_before + ",'place_2':" + place_2_before + ",'place_3':" + place_3_before + "}}";

      // Serial local
      Serial.print('*');
      Serial.print(param);
      Serial.println('#');

      // Serial esp
      mySerial.print("*");
      mySerial.print(param);
      mySerial.println("#");
      mySerial.println();
    }
    timer_cnt = 0;
  }
  timer_cnt++;
  delay(200);

}

float sensor_1(void)
{
  digitalWrite(trig_1, LOW);
  delayMicroseconds(10000);
  digitalWrite(trig_1, HIGH);
  delayMicroseconds(10);
  digitalWrite(trig_1, LOW);
  duration1 = pulseIn(echo_1, HIGH);
  distanceCM_1 = duration1 * 0.0343 / 2;
  return distanceCM_1;
}

float sensor_2(void)
{
  digitalWrite(trig_2, LOW);
  delayMicroseconds(10000);
  digitalWrite(trig_2, HIGH);
  delayMicroseconds(10);
  digitalWrite(trig_2, LOW);
  duration2 = pulseIn(echo_2, HIGH);
  distanceCM_2 = duration2 * 0.0343 / 2;
  return distanceCM_2;
}

float sensor_3(void)
{
  digitalWrite(trig_3, LOW);
  delayMicroseconds(10000);
  digitalWrite(trig_3, HIGH);
  delayMicroseconds(10);
  digitalWrite(trig_3, LOW);
  duration3 = pulseIn(echo_3, HIGH);
  distanceCM_3 = duration3 * 0.0343 / 2;
  return distanceCM_3;
}

void gates() {
  if ((digitalRead(entrance_gate) == LOW) && (queue != 0)) {
    servo2.write(135);

    String param = "{'sender':'gate_in','business_id':'" + business_id + "','machine_id':'" + machine_id + "'}";

    // Serial local
    Serial.print('*');
    Serial.print(param);
    Serial.println('#');

    // Serial esp
    mySerial.print("*");
    mySerial.print(param);
    mySerial.println("#");
    mySerial.println();

    queue -= 1;
    delay(3000);
  } else if (digitalRead(entrance_gate) == LOW && queue == 0) {
    lcd.clear();
    lcd.setCursor(0, 0);
    lcd.print("Maaf Penuh!");
    delay(1500);
    lcd.clear();
  }


  if (digitalRead(entrance_gate) == HIGH) {
    servo2.write(45);
  }


  if (digitalRead(exit_gate) == LOW && queue != parkiran) {
    servo1.write(0);

    String param = "{'sender':'gate_out','business_id':'" + business_id + "','machine_id':'" + machine_id + "'}";

    // Serial local
    Serial.print('*');
    Serial.print(param);
    Serial.println('#');

    // Serial esp
    mySerial.print("*");
    mySerial.print(param);
    mySerial.println("#");
    mySerial.println();

    queue += 1;
    delay(3000);
  }



  if (digitalRead(exit_gate) == HIGH) {
    servo1.write(75);
  }

}
