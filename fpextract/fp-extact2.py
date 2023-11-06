import serial
import time
import struct

# Configure the UART port and baud rate
ser = serial.Serial('/dev/serial/by-id/usb-FTDI_FT232R_USB_UART_A10OEEV8-if00-port0', 9600, timeout=1)

# Function to read response with timeout
def read_response(length, timeout=5):
    response = bytes()
    start_time = time.time()
    while len(response) < length:
        response += ser.read(length - len(response))
        if time.time() - start_time > timeout:
            break
    return response

# Get the number of stored templates
ser.write(struct.pack('>H', 0x0001))  # GetTemplateCount command

response = read_response(12)  # Read response
if len(response) < 12:
    print("No response received. Failed to get the template count.")
    ser.close()
    exit(1)

template_count = struct.unpack('>H', response[9:11])[0]

if template_count == 0:
    print('No templates found on the sensor.')
    ser.close()
    exit(0)

# Create a list to store the templates
all_templates = []

# Loop through the templates and read each one
for template_id in range(1, template_count + 1):
    ser.write(struct.pack('>H', 0x0002))  # LoadTemplate command
    ser.write(struct.pack('>H', template_id))

    response = read_response(12)  # Read response
    if len(response) < 12:
        print(f'No response received for template {template_id}.')
        continue

    # Ensure the response indicates success before reading the template
    if struct.unpack('>H', response[9:11])[0] != 0x00:
        print(f'Failed to load template {template_id}.')
        continue

    template_data = read_response(498)  # Read the template
    all_templates.append(template_data)

# Save the templates to a file
with open('fingerprint_templates.dat', 'wb') as file:
    for template in all_templates:
        file.write(template)

print(f'Saved {template_count} fingerprint templates to fingerprint_templates.dat')

ser.close()

