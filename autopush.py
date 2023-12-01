import unittest
import mysql.connector

def get_user_input():
    response = input("Do you want to provide custom data for student insertion? (y/n): ").lower()
    if response in ['y', 'yes']:
        while True:
            try:
                user_input = int(input("Enter a number above 100: "))
                if user_input > 100:
                    break  # exit the loop if the input is above 100
                else:
                    print("Number must be above 100. Please try again.")
            except ValueError:
                print("Invalid input. Please enter a valid number.")
        firstName = input("Enter first name: ")
        lastName = input("Enter last name: ")
    else:
        # Default values
        userId = 1
        firstName = 'John'
        lastName = 'Doe'

    return userId, firstName, lastName

class TestMySQLConnection(unittest.TestCase):

    @classmethod
    def setUpClass(cls):
        # This method is called once before any test methods
        # Establish a connection and cursor for all tests
        cls.db_config = {
            'host': '34.194.132.130',
            'user': 'test',
            'password': 'test123',
            'database': 'touch_and_go_test',
        }
        cls.connection = mysql.connector.connect(**cls.db_config)
        cls.cursor = cls.connection.cursor()

        # Get user input for default values
        cls.userId, cls.firstName, cls.lastName = get_user_input()

    @classmethod
    def tearDownClass(cls):
        # This method is called once after all test methods
        # Close the connection after all tests and delete the test data
        if cls.connection.is_connected():
            print("Cleaning up test data...")
            cls.cursor.execute("DELETE FROM student WHERE userId = %s", (cls.userId,))  # Modify the condition as needed
            cls.connection.commit()
            cls.connection.close()

    def test_database_connection(self):
        print("Testing database connection...")
        try:
            self.assertIsNotNone(self.connection, "Connection should not be None")
            print("Database connection successful!")
        except mysql.connector.Error as err:
            self.fail(f"Error: {err}")

    def test_insert_student(self):
        print("Testing student insertion...")
        try:
            insert_query = "INSERT INTO student (userId, firstName, lastName) VALUES (%s, %s, %s)"
            data = (self.userId, self.firstName, self.lastName)

            self.cursor.execute(insert_query, data)
            self.connection.commit()

            self.assertEqual(self.cursor.rowcount, 1, "One row should be inserted")
            print("Student insertion successful!")

        except mysql.connector.Error as err:
            self.fail(f"Error: {err}")

if __name__ == '__main__':
    unittest.main()
