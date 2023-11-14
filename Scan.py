import sys
sys.path.append('lcdlib')
from lcd_api import LcdApi
from i2c_lcd import I2cLcd
import time
import serial
import adafruit_fingerprint
import mysql.connector
from datetime import datetime

db_config = {
    'host': '34.194.132.130',
    'user': 'test',
    'password': 'test123',
    'database': 'touch_and_go_test',
}

I2C_ADDR = 0x27
I2C_NUM_ROWS = 4
I2C_NUM_COLS = 20

lcd = I2cLcd(1, I2C_ADDR, I2C_NUM_ROWS, I2C_NUM_COLS)

# Initialize fingerprint sensor and UART
uart = serial.Serial("/dev/ttyUSB0", baudrate=57600, timeout=1)
finger = adafruit_fingerprint.Adafruit_Fingerprint(uart)

def insertdb(index):
    try:
        connection = mysql.connector.connect(**db_config)
        cursor = connection.cursor()

        select_query = "SELECT userID FROM student WHERE fingerId = %s"
        
        cursor.execute(select_query, (index,))
        
        result = cursor.fetchone()  # Assuming fingerId is unique, use fetchone
        userId = result[0]  # Return the UserID

        insert_query = "INSERT INTO fingerprint VALUES (%s, %s)"

        timestamp = datetime.now()
        data = (userId, timestamp)

        cursor.execute(insert_query, data)
        connection.commit()
    
    except mysql.connector.Error as err:
        print(f"Error: {err}")
    finally:
        if 'connection' in locals():
            connection.close()


def get_fingerprint_name():
    print("Waiting for a fingerprint scan...")
    lcd.clear()
    lcd.putstr("Place finger on sensor...")

    while finger.get_image() != adafruit_fingerprint.OK:
        pass
    if finger.image_2_tz(1) == adafruit_fingerprint.OK:
            if finger.finger_search() == adafruit_fingerprint.OK:
                lcd.clear()
                lcd.putstr("Fingerprint found")
                print("Fingerprint found")
                return finger.finger_id
    time.sleep(1)  # Add a short delay to avoid continuous checking

try:
    while True:
        fingerprint_id = get_fingerprint_name()
        insertdb(fingerprint_id)
        print("Detected #", fingerprint_id)
        time.sleep(5)
except KeyboardInterrupt:
    print("Program terminated")
