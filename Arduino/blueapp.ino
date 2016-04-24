#include <Ultrasonic.h>
#include <SoftwareSerial.h>
#define RxD 0
#define TxD 1
#define LED 13
 
//(Trig PIN,Echo PIN)
Ultrasonic ultrasonic(9,10,6000);   //Configuracion del ultrasonic que indica que el pin 9
                                    //es Trig, el pin 10 es Echo. Con el valor 6000 obtenemos
                                    //un rango máximo de 105cm.
long int lectura;                   //Variable global lectura.
#define DISTANCIA_RETROCESO 20      //Definición de constante.
#define DISTANCIA_LIMITE 100        //Definición de constante.
SoftwareSerial BTSerial(RxD, TxD);
byte pinEstado = 0;

void setup(){
  Serial.begin(9600); //sets serial port for communication
  BTSerial.begin(9600);
  BTSerial.flush();
  delay(500);
 
}

void loop(){
  lectura = ultrasonic.Ranging(CM);  //leemos la distancia que proporciona el sensor.
  Serial.println(lectura);
  BTSerial.println(lectura);//prints the values coming from the sensor on the screen
  delay(500);
  // Esperamos ha recibir datos.
  if (BTSerial.available()){
    char command = BTSerial.read();
    BTSerial.flush();
    Serial.println(command);
       
  }
  
}


