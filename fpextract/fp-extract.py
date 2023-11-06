import adafruit_fingerprint
import serial

# Initialize serial connection to fingerprint sensor
uart = serial.Serial("/dev/ttyUSB0", baudrate=57600, timeout=1)

finger = adafruit_fingerprint.Adafruit_Fingerprint(uart)

while finger.get_image() != adafruit_fingerprint.OK:
            pass

while finger.image_2_tz(1) != adafruit_fingerprint.OK:
            pass
                
filename = "fingerprint_template.bin"
if finger.save_template(filename):
            print("Template saved to", filename)
else:
            print("Error saving template")
                    

def save_template(self, filename: str, sensorbuffer: str = "char", slot: int = 1) -> bool:
            """Requests the sensor to transfer the fingerprint template and save it to a file."""
            if slot not in (1, 2):
                        slot = 2
            if sensorbuffer == "char":
                        self._send_packet([_UPLOAD, slot])
            else:
                        raise RuntimeError("Unknown sensor buffer type")
            if self._get_packet(12)[0] == 0:
                        res = self._get_data(9)
                        with open(filename, "wb") as f:
                                    f.write(bytes(res))
                        return True
            else:
                        return False
                                                                
