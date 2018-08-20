#!/usr/bin/env python
# -*- coding: utf8 -*-
#
#    AUTHOR: Matthew Loewen
#    RFID code: modified from Mario Gomez <mario.gomez@teubi.co>


import RPi.GPIO as GPIO
import MFRC522
import signal
import requests #for api
import json
import time #for LCD
import Adafruit_CharLCD as LCD #for lCD

#make infinite loop looking for card to read
continue_reading = True


# Raspberry Pi pin configuration for LCD:
lcd_rs        = 27 # Note this might need to be changed to 21 for older revision Pi's.
lcd_en        = 24
lcd_d4        = 23
lcd_d5        = 17
lcd_d6        = 18
lcd_d7        = 22
lcd_backlight = 7

# Define LCD column and row size for 16x2 LCD.
lcd_columns = 16
lcd_rows    = 2

#init the LCD screen
lcd = LCD.Adafruit_CharLCD(lcd_rs, lcd_en, lcd_d4, lcd_d5, lcd_d6, lcd_d7,
                           lcd_columns, lcd_rows, lcd_backlight)

print("Time Tracker Application \n Written by: Matthew Loewen \n For A3 Lab ")
print("Ready to read your RFID card")

# Capture SIGINT for cleanup when the script is aborted
def end_read(signal,frame):
    global continue_reading
    print("Ctrl+C captured, ending read.")
    continue_reading = False
    GPIO.cleanup()
# we read the uid in 5 sections from the card
# this makes sure each secion is the same length
def padUid(uid):
    int = str(uid)
    while(len(int) < 3):
        int = "0" + int
    return int

# Hook the SIGINT
signal.signal(signal.SIGINT, end_read)

#baseurl for the api
baseUrl = "http://mloewen.com/projects/timetracker/api.php?"

# Create an object of the class MFRC522
MIFAREReader = MFRC522.MFRC522()

# This loop keeps checking for chips. If one is near it will get the UID and authenticate
while continue_reading:
    
    # Scan for cards    
    (status,TagType) = MIFAREReader.MFRC522_Request(MIFAREReader.PICC_REQIDL)

    # If a card is found
    if status == MIFAREReader.MI_OK:
        #print to the lcd screen...
        print("Card detected")
        # Get the UID of the card
        (status,uid) = MIFAREReader.MFRC522_Anticoll()

        # If we have the UID, continue
        if status == MIFAREReader.MI_OK:
            finalUid = ""
            for i in range(len(uid)):
                finalUid = finalUid+str(padUid(uid[i]))
            print(finalUid)
            
            #check if the user exists in the api
                
            #if user exists clock them in
            
            #if the user doesn't get their name and make account 
            name = input("enter name for new user: ")
            req = requests.get(baseUrl+"command=newUser&userName="+name+"&badgeID="+finalUid)
            req = req.json()
            print(req["message"])
            lcd.message(req["message"])
    
            
##                r = requests.get("http://mloewen.com/projects/timetracker/api.php?command=newUser&userName=theguy&badgeID=123123123123")
##print(r.status_code)
##print(r.text)

            
            

