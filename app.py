from flask import Flask, render_template, request, jsonify
from datetime import datetime
import mysql.connector

app = Flask(__name__, static_folder='static')

# Create MySQL database connection
conn = mysql.connector.connect(
    host="db4free.net",
    user="mtytsree@localhost",
    password="RhFNK7*VWcwwcbm",
    port=3306
)
cursor = conn.cursor()
cursor.execute("CREATE DATABASE IF NOT EXISTS db4free_sys")
cursor.execute("USE db4free_sys")
cursor.execute("CREATE TABLE IF NOT EXISTS data (Item_name VARCHAR(255), Date DATE, Time TIME, Weight FLOAT, Total FLOAT)")

options = {
    "python": 5.0,
    "customtkinter": 3.0,
    "widgets": 2.0,
    "options": 4.0,
    "menu": 6.0,
    "combobox": 7.0,
    "dropdown": 8.0,
    "search": 9.0
}

# Home page route
@app.route('/')
def home():
    return render_template('index.html')

# API endpoint for submitting data
@app.route('/api/submit', methods=['POST'])
def submit():
    option_name = request.json.get('option')
    weight = float(request.json.get('weight'))
    total = options[option_name] * weight

    # Save data to database
    submission_date = datetime.now().date()
    submission_time = datetime.now().time()
    cursor.execute("INSERT INTO data (Item_name, Date, Time, weight, total) VALUES (%s, %s, %s, %s, %s)",
                   (option_name, submission_date, submission_time, weight, total))
    conn.commit()

    return jsonify({
        'option': option_name,
        'weight': weight,
        'total': total
    })

# API endpoint for retrieving data
@app.route('/api/data', methods=['GET'])
def get_data():
    cursor.execute("SELECT * FROM data")
    data_rows = cursor.fetchall()
    data = []
    for row in data_rows:
        item = {
            'option': row[0],
            'date': row[1].isoformat(),
            'time': row[2].isoformat(),
            'weight': row[3],
            'total': row[4]
        }
        data.append(item)

    return jsonify(data)

if __name__ == "__main__":
    app.run(host='0.0.0.0', port=8080)
