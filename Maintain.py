# SPDX-FileCopyrightText: 2021 ladyada for Adafruit Industries
# SPDX-License-Identifier: MIT

##for lcd support
import sys

sys.path.append('lcdlib')

from lcd_api import LcdApi
from i2c_lcd import I2cLcd

##for adafruit lib
import time
import serial

import adafruit_fingerprint

##for mysql

import mysql.connector

##find a way to obfuscate this for security
db_config = {
    'host': '34.194.132.130',
    'user': 'test',
    'password': 'test123',
    'database': 'touch_and_go_test',
}

# import board
# uart = busio.UART(board.TX, board.RX, baudrate=57600)

# If using with a computer such as Linux/RaspberryPi, Mac, Windows with USB/serial converter:
uart = serial.Serial("/dev/ttyUSB0", baudrate=57600, timeout=1)

# If using with Linux/Raspberry Pi and hardware UART:
# uart = serial.Serial("/dev/ttyS0", baudrate=57600, timeout=1)

# If using with Linux/Raspberry Pi 3 with pi3-disable-bt
# uart = serial.Serial("/dev/ttyAMA0", baudrate=57600, timeout=1)

finger = adafruit_fingerprint.Adafruit_Fingerprint(uart)

##initialize lcd
I2C_ADDR = 0x27
I2C_NUM_ROWS = 4
I2C_NUM_COLS = 20

lcd = I2cLcd(1, I2C_ADDR, I2C_NUM_ROWS, I2C_NUM_COLS)

def insertdb(index):
    try:
        connection = mysql.connector.connect(**db_config)
        cursor = connection.cursor()
    
        # Perform database operations here
        # Example: cursor.execute("INSERT INTO your_table (column1, column2) VALUES (%s, %s)", (value1, value2))
        # Example: cursor.execute("SELECT * FROM your_table")
        # Don't forget to commit changes if necessary: connection.commit()
        
        # Execute your SELECT query
        #query = "SELECT * FROM student"
        #cursor.execute(query)
    
        # Fetch all the rows
        #rows = cursor.fetchall()
    
        # Print the results to the console
        #for row in rows:
        #    print(row)
        
        #id first name lastname email password
        insert_query = "INSERT INTO touch_and_go_test VALUES (%s, %s, %s, %s, %s)"
        
        print("Enter your first name: ")
        fname = input()
        print("Enter your last name: ")
        lname = input()
        print("Enter your email: ")
        email = input()
        print("Enter your password: ")
        pword = input()
        
        data = (index, fname, lname, email, pword)
        
        cursor.execute(insert_query, data)
        connection.commit()
        
    except mysql.connector.Error as err:
        print(f"Error: {err}")
    finally:
        if 'connection' in locals():
            connection.close()

# pylint: disable=too-many-branches
def get_fingerprint_detail():
    """Get a finger print image, template it, and see if it matches!
    This time, print out each error instead of just returning on failure"""
    print("Getting image...", end="")
    i = finger.get_image()
    if i == adafruit_fingerprint.OK:
        print("Image taken")
    else:
        if i == adafruit_fingerprint.NOFINGER:
            print("No finger detected")
        elif i == adafruit_fingerprint.IMAGEFAIL:
            print("Imaging error")
        else:
            print("Other error")
        return False

    print("Templating...", end="")
    i = finger.image_2_tz(1)
    if i == adafruit_fingerprint.OK:
        print("Templated")
    else:
        if i == adafruit_fingerprint.IMAGEMESS:
            print("Image too messy")
        elif i == adafruit_fingerprint.FEATUREFAIL:
            print("Could not identify features")
        elif i == adafruit_fingerprint.INVALIDIMAGE:
            print("Image invalid")
        else:
            print("Other error")
        return False

    print("Searching...", end="")
    i = finger.finger_fast_search()
    # pylint: disable=no-else-return
    # This block needs to be refactored when it can be tested.
    if i == adafruit_fingerprint.OK:
        print("Found fingerprint!")
        return True
    else:
        if i == adafruit_fingerprint.NOTFOUND:
            print("No match found")
        else:
            print("Other error")
        return False


# pylint: disable=too-many-statements
def enroll_finger(location):
    """Take a 2 finger images and template it, then store in 'location'"""
    lcd.clear()
    for fingerimg in range(1, 3):
        if fingerimg == 1:
            lcd.putstr("Place finger on ")
            lcd.move_to(0,1)
            lcd.putstr("sensor...")
            print("Place finger on sensor...", end="")
        else:
            lcd.clear()
            lcd.putstr("Place same finger")
            lcd.move_to(0,1)
            lcd.putstr(" again...")
            print("Place same finger again...", end="")

        while True:
            i = finger.get_image()
            if i == adafruit_fingerprint.OK:
                print("Image taken")
                break
            if i == adafruit_fingerprint.NOFINGER:
                print(".", end="")
            elif i == adafruit_fingerprint.IMAGEFAIL:
                print("Imaging error")
                return False
            else:
                print("Other error")
                return False

        print("Templating...", end="")
        i = finger.image_2_tz(fingerimg)
        if i == adafruit_fingerprint.OK:
            print("Templated")
        else:
            if i == adafruit_fingerprint.IMAGEMESS:
                print("Image too messy")
            elif i == adafruit_fingerprint.FEATUREFAIL:
                print("Could not identify features")
            elif i == adafruit_fingerprint.INVALIDIMAGE:
                print("Image invalid")
            else:
                print("Other error")
            return False

        if fingerimg == 1:
            lcd.clear()
            lcd.putstr("Remove finger")
            print("Remove finger")
            time.sleep(1)
            while i != adafruit_fingerprint.NOFINGER:
                i = finger.get_image()

    print("Creating model...", end="")
    i = finger.create_model()
    if i == adafruit_fingerprint.OK:
        print("Created")
    else:
        if i == adafruit_fingerprint.ENROLLMISMATCH:
            print("Prints did not match")
        else:
            print("Other error")
        return False

    print("Storing model #%d..." % location, end="")
    i = finger.store_model(location)
    if i == adafruit_fingerprint.OK:
        lcd.clear()
        lcd.putstr("Stored successfully")
        print("Stored")
        time.sleep(2)
        lcd.clear()
        lcd.putstr("Enter your name")
        name = input("Enter your name: ")
        time.sleep(2)
        lcd.clear()
    else:
        if i == adafruit_fingerprint.BADLOCATION:
            print("Bad storage location")
        elif i == adafruit_fingerprint.FLASHERR:
            print("Flash storage error")
        else:
            print("Other error")
        return False

    return True


##################################################
   
def get_num(max_number):
    """Use input() to get a valid number from 0 to the maximum size
    of the library. Retry till success!"""
    i = -1
    while (i > max_number - 1) or (i < 0):
        try:
            i = int(input("Enter ID # from 0-{}: ".format(max_number - 1)))
        except ValueError:
            pass
    return i


while True:
    print("----------------")
    if finger.read_templates() != adafruit_fingerprint.OK:
        raise RuntimeError("Failed to read templates")
    print("Fingerprint templates: ", finger.templates)
    if finger.count_templates() != adafruit_fingerprint.OK:
        raise RuntimeError("Failed to read templates")
    print("Number of templates found: ", finger.template_count)
    if finger.read_sysparam() != adafruit_fingerprint.OK:
        raise RuntimeError("Failed to get system parameters")
    print("Size of template library: ", finger.library_size)
    print("e) enroll print")
    print("d) delete print")
    print("r) reset library")
    print("q) quit")
    print("----------------")
    c = input("> ")

    if c == "e":
        index = get_num(finger.library_size)
        if enroll_finger(index):
            insertdb(index)
    if c == "d":
        if finger.delete_model(get_num(finger.library_size)) == adafruit_fingerprint.OK:
            print("Deleted!")
        else:
            print("Failed to delete")
    if c == "r":
        if finger.empty_library() == adafruit_fingerprint.OK:
            print("Library empty!")
        else:
            print("Failed to empty library")
    if c == "q":
        print("Exiting fingerprint example program")
        raise SystemExit
