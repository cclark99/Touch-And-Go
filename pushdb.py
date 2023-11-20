import mysql.connector

# Replace these with your actual MySQL server details
db_config = {
    'host': '34.194.132.130',
    'user': 'test',
    'password': 'test123',
    'database': 'touch_and_go_test',
}

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
    insert_query = "INSERT INTO student (userId, firstName, lastName) VALUES (%s, %s, %s)"
    
    print("Enter ID: ")
    index = input()
    print("Enter your first name: ")
    fname = input()
    print("Enter your last name: ")
    lname = input()
   
    data = (index, fname, lname)
    
    cursor.execute(insert_query, data)
    connection.commit()
    
except mysql.connector.Error as err:
    print(f"Error: {err}")
finally:
    if 'connection' in locals():
        connection.close()
