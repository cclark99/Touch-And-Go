import sys

sys.path.append('lcdlib')

from lcd_api import LcdApi
from i2c_lcd import I2cLcd
 
I2C_ADDR = 0x27
I2C_NUM_ROWS = 4
I2C_NUM_COLS = 20
 
lcd = I2cLcd(1, I2C_ADDR, I2C_NUM_ROWS, I2C_NUM_COLS)
 
lcd.putstr("Great! It Works!")
lcd.move_to(0,3)
lcd.putstr("freva.com")
