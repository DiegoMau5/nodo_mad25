int LED = 12;
int BUTTON = 4;

int buttonState = 0;         
int buttonStay = 0;
int buttonChange = 0;


void setup()
{
  pinMode(LED, OUTPUT);
  pinMode(BUTTON, INPUT);
  digitalWrite(LED, LOW);
}



void loop()
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
}







  