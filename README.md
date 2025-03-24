# 🛰️ Project People Flow – Real-Time Occupancy Dashboard

**Project People Flow** is a real-time building occupancy monitoring dashboard built with **PHP**, **MySQL**, and **Chart.js**. It simulates and visualizes the movement of employees and visitors in a building.

This project was created to demonstrate full-stack development, data visualization, and PDF reporting skills — tailored toward smart building analytics and companies like **Xovis**.

---

## 📊 Features

- ✅ CSV upload of people flow simulation data
- ✅ Real-time total entry counter
- ✅ Peak time visualization (entries per minute)
- ✅ People type breakdown (employee vs visitor – pie chart)
- ✅ Daily traffic report table
- ✅ PDF report export for management
- ✅ Simple, clean UI with upload & dashboard navigation

---
🧱 Project Structure

Part 1: people-flow-simulator
Built with: HTML + JavaScript

Purpose: Simulate entries/exits and export CSV files

Part 2: project-people-flow
Built with: PHP + MySQL + Chart.js

Purpose: Upload CSV, store in DB, visualize, and export PDF reports

---

## 📁 Folder Structure

```
project-people-flow/
├── index.php          # Upload and Clear interface
├── upload.php         # CSV parser and DB importer
├── clear.php          # Deletes all database records
├── dashboard.php      # Main dashboard with charts and report
├── uploads/           # Optional: folder to store uploaded CSVs
```

---

## 💡 Tech Stack

- **Frontend**: HTML5, CSS3, Chart.js  
- **Backend**: PHP (vanilla), MySQL  
- **Libraries**:
  - [`Chart.js`](https://www.chartjs.org/) – for beautiful data visualizations
  - [`html2pdf.js`](https://ekoopmans.github.io/html2pdf/) – for exporting the dashboard to PDF

---

## 🔌 How to Run Locally

1. Install **WAMP**, **XAMPP**, or any PHP-MySQL stack.
2. Place the folder inside `www` or `htdocs` (e.g. `C:\wamp64\www\project-people-flow`).
3. Create a database called `xovis_db`, and use the following SQL to create the table:

```sql
CREATE TABLE people_flow (
    id INT AUTO_INCREMENT PRIMARY KEY,
    person_id VARCHAR(50),
    person_type VARCHAR(20),
    entry_time DATETIME(3),
    exit_time DATETIME(3)
);
```

4. Open your browser and visit:
```
http://localhost/project-people-flow/
```

---

## 📂 Sample CSV Format

```csv
ID,Type,Entry Time,Exit Time,Duration (seconds)
33973,employee,2025-03-23T02:07:47.234Z,2025-03-23T02:07:54.196Z,6.962
41352,visitor,2025-03-23T02:07:49.032Z,2025-03-23T02:07:54.862Z,5.83
...
```

---

## 📄 Output PDF Example

After uploading data, open the dashboard and click **“Download PDF Report”** to generate a clean PDF summary of the day's stats and charts — ideal for management reporting.

---

## 💼 Author

**Shakir**  
- Data Science Master's Student  
- 🇩🇪 Based in Germany  
- 📧 [mr.shakirullah@gmail.com](mailto:mr.shakirullah@gmail.com)  
- 🔗 [LinkedIn](https://www.linkedin.com/) *(Add your link if you want)*

---

## 📌 License

Open-source project available for educational, personal, and demo use.
