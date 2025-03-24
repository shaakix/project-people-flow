# 🛰️ Project People Flow – Simulator & Dashboard

**Project People Flow** is a two-part system that simulates and analyzes foot traffic within a building. It consists of a front-end **People Flow Simulator** and a back-end **Dashboard Analytics System**, built to showcase full-stack development, data visualization, and smart reporting for real-world people-tracking scenarios.

---

## 🧩 Project Structure

```
project-people-flow/
├── simulator/       # Frontend simulation tool
│   ├── index.html
│   ├── script.js
│   └── style.css
│
├── dashboard/       # Backend visualization and reporting
│   ├── index.php
│   ├── dashboard.php
│   ├── upload.php
│   ├── clear.php
│   ├── uploads/
│   └── README.md
```

---

## 🎮 1. People Flow Simulator (Frontend)

- Built with **HTML5 + JavaScript**
- Simulates employees and visitors entering/exiting a building
- Generates a CSV file with:
  - Person ID
  - Person Type (employee/visitor)
  - Entry Time
  - Exit Time
  - Duration inside

🟢 **Output**: `people-flow-data.csv` ready for upload into the dashboard

---

## 📊 2. Project Dashboard (Backend)

- Built with **PHP**, **MySQL**, and **Chart.js**
- Upload CSV files from simulator
- Stores data in a MySQL database
- Displays:

| Feature                      | Description                                   |
|-----------------------------|-----------------------------------------------|
| ✅ Total People Today        | Counter of all entries for the selected day   |
| ✅ Peak Time Graph           | Entries per minute (bar chart)                |
| ✅ People Type Breakdown     | Pie chart: employees vs. visitors             |
| ✅ Daily Traffic Report      | Tabular view of daily counts                  |
| ✅ PDF Report Export         | One-click downloadable report                 |

---

## 🛠️ Technologies Used

- **Frontend**: HTML5, CSS3, JavaScript
- **Backend**: PHP (Vanilla), MySQL
- **Libraries**:
  - [Chart.js](https://www.chartjs.org/) – for data visualization
  - [html2pdf.js](https://ekoopmans.github.io/html2pdf/) – for report generation

---

## 🖥️ How to Run Locally

1. Install [WAMP](https://www.wampserver.com/en/) or [XAMPP](https://www.apachefriends.org/index.html)
2. Place the `project-people-flow` folder inside your `www` or `htdocs` directory
3. Create a MySQL database `xovis_db` and run:

```sql
CREATE TABLE people_flow (
    id INT AUTO_INCREMENT PRIMARY KEY,
    person_id VARCHAR(50),
    person_type VARCHAR(20),
    entry_time DATETIME(3),
    exit_time DATETIME(3)
);
```

4. Open your browser:
   - Run simulator at `simulator/index.html` (locally)
   - Access dashboard at: `http://localhost/project-people-flow/dashboard/index.php`

---

## 📥 Sample CSV Format

```csv
ID,Type,Entry Time,Exit Time,Duration (seconds)
6248,employee,2025-03-23T02:07:47.234Z,2025-03-23T02:07:54.196Z,6.96
2791,visitor,2025-03-23T02:07:49.032Z,2025-03-23T02:07:54.862Z,5.83
```

---

## 📄 PDF Report

Click the **"Download PDF Report"** button on the dashboard to export daily statistics and charts for management or archival use.

---

## 👨‍💻 Author

**Shakir**  
🎓 MSc Data Science  
🇩🇪 Based in Germany  
📧 [mr.shakirullah@gmail.com](mailto:mr.shakirullah@gmail.com)

---

## 📄 License

This project is open-source and available for educational, portfolio, and demo purposes.
