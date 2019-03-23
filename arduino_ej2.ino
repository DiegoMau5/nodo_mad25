#include <Bridge.h>
#include <HttpClient.h>

int LED = 12;
int BUTTON = 4;

int buttonState = 0;         
int buttonStay = 0;
int buttonChange = 0;

bool alreadyDone = false;

void setup()
{
  pinMode(LED, OUTPUT);
  pinMode(BUTTON, INPUT);
  digitalWrite(LED, LOW);
  
  //INTERNET
  Bridge.begin();
  Serial.begin(9600);
  while(!Serial);
}


void loop(){
  if(alreadyDone == false){
    HttpClient client;
  client.get("https://atenea-ia.tk/yaya/api/insert_php.php?test=12");
  
  while (client.available()) {
    char c = client.read();
    Serial.print(c);
  }
  Serial.flush();

  delay(5000);
  
  }
  
  alreadyDone = true;
}



/*void loop()
{
  // read the state of the pushbutton value:
  buttonState = digitalRead(BUTTON);

  // check if the pushbutton is pressed.
  // if it is, the buttonState is HIGH:
  if (buttonState == HIGH) {
    // switch is on
       
    if (buttonChange == 1) {
      //switch was just recently changed to on
      buttonChange = 0;
      
      if ( buttonStay == 0 ) {
        buttonStay = 1;
        digitalWrite(LED, HIGH);
      } else {
        buttonStay = 0;
        digitalWrite(LED, LOW);
      }
    }
    
  } else {
    // switch is off
    buttonChange = 1;
  }
  
  // delay(5);
}*/







  