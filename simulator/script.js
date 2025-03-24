// Select the canvas and get its 2D rendering context
const canvas = document.getElementById("simulationCanvas");
const ctx = canvas.getContext("2d");

// Set canvas size
canvas.width = 500;
canvas.height = 600;

// Function to draw the building (rectangle)
function drawBuilding() {
    ctx.fillStyle = "#999"; // Gray color for the building
    ctx.fillRect(150, 100, 200, 400); // (x, y, width, height)

    // Draw entrance (top)
    ctx.fillStyle = "black";
    ctx.fillRect(225, 90, 50, 10); // Entrance at the top

    // Draw exit (bottom)
    ctx.fillRect(225, 500, 50, 10); // Exit at the bottom

    // Add "Entrance" label
    ctx.fillStyle = "black";
    ctx.font = "16px Arial";
    ctx.textAlign = "center";
    ctx.fillText("Entrance", 250, 80); // (x=center of entrance, y=above entrance)

    // Add "Exit" label
    ctx.fillText("Exit", 250, 530); // (x=center of exit, y=below exit)
}

// Clear the canvas and draw the building
function updateCanvas() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    drawBuilding();
}

// Initial draw when page loads
updateCanvas();

/*
// Arrays to store the people objects
let people = [];

// Define person object structure
class Person {
    constructor(type, x, speed) {
        this.type = type; // "employee" or "visitor"
        this.x = x;
        this.y = 0; // Start from the top of the screen
        this.speed = speed;
        this.entryTime = null;
        this.exitTime = null;
        this.hasEntered = false; // Track if they have entered the building
    }

    // Move person downwards
    move() {
        if (!this.hasEntered && this.y >= 90) { 
            this.entryTime = new Date(); // Record entry time when they enter the building
            this.hasEntered = true;
        }

        if (this.y < canvas.height) {
            this.y += this.speed;
        } else if (this.hasEntered && this.exitTime === null) { 
            this.exitTime = new Date(); // Record exit time when they leave the screen
        }
    }

    // Draw person on canvas
    draw() {
        ctx.fillStyle = this.type === "employee" ? "blue" : "green";
        ctx.beginPath();
        ctx.arc(this.x, this.y, 5, 0, Math.PI * 2);
        ctx.fill();
    }
}

// Function to spawn people randomly from the top of the screen
function spawnPerson() {
    let type = Math.random() > 0.5 ? "employee" : "visitor";
    let x = Math.random() * (275 - 175) + 175; // Random within entrance width
    let speed = Math.random() * 2 + 1; // Random speed between 1 and 3

    let person = new Person(type, x, speed);
    people.push(person);
}

// Update the canvas with people movement
function updateSimulation() {
    updateCanvas(); // Redraw building

    people.forEach((person) => {
        person.move();
        person.draw();
    });

    requestAnimationFrame(updateSimulation);
}

// Start simulation
document.getElementById("startButton").addEventListener("click", () => {
    document.getElementById("startButton").disabled = true;
    document.getElementById("stopButton").disabled = false;

    people = []; // Reset people array
    updateSimulation(); // Start movement
    spawnInterval = setInterval(spawnPerson, 1000); // Generate people every second
});

// Stop simulation
document.getElementById("stopButton").addEventListener("click", () => {
    clearInterval(spawnInterval);
    document.getElementById("startButton").disabled = false;
    document.getElementById("stopButton").disabled = true;
});
*/


// Arrays to store the people objects and recorded data
let people = [];
let peopleData = [];

// Define person object structure
class Person {
    constructor(type, x, speed) {
        this.type = type; // "employee" or "visitor"
        this.x = x;
        this.y = 0; // Start from the top of the screen
        this.speed = speed;
        this.entryTime = null;
        this.exitTime = null;
        this.hasEntered = false; // Track if they have entered the building
        this.id = Math.floor(Math.random() * 100000); // Unique ID for each person
    }

    // Move person downwards
    move() {
        if (!this.hasEntered && this.y >= 90) { 
            this.entryTime = new Date(); // Record entry time when they enter the building
            this.hasEntered = true;
        }

        if (this.y < canvas.height) {
            this.y += this.speed;
        } else if (this.hasEntered && this.exitTime === null) { 
            this.exitTime = new Date(); // Record exit time when they leave the screen

            // Save entry & exit data
            let duration = (this.exitTime - this.entryTime) / 1000; // Duration in seconds
            peopleData.push({
                id: this.id,
                type: this.type,
                entryTime: this.entryTime.toISOString(),
                exitTime: this.exitTime.toISOString(),
                duration: duration.toFixed(2)
            });
        }
    }

    // Draw person on canvas
    draw() {
        ctx.fillStyle = this.type === "employee" ? "blue" : "green";
        ctx.beginPath();
        ctx.arc(this.x, this.y, 5, 0, Math.PI * 2);
        ctx.fill();
    }
}

// Function to display occupancy of the building in real time
function updateOccupancyDisplay() {
    const insideCount = people.filter(p => p.hasEntered && p.exitTime === null).length;
    document.getElementById("occupancyDisplay").textContent = 
        `People currently in the building: ${insideCount}`;
}

// Function to spawn people randomly from the top of the screen
function spawnPerson() {
    let type = Math.random() > 0.5 ? "employee" : "visitor";
    let x = Math.random() * (275 - 175) + 175; // Random within entrance width
    let speed = Math.random() * 2 + 1; // Random speed between 1 and 3

    let person = new Person(type, x, speed);
    people.push(person);
}

// Update the canvas with people movement
function updateSimulation() {
    updateCanvas(); // Redraw building

    people.forEach((person) => {
        person.move();
        person.draw();
    });

    updateOccupancyDisplay(); // Update UI
    requestAnimationFrame(updateSimulation);
}

// Convert Data to CSV Format
function exportToCSV() {
    let csvContent = "data:text/csv;charset=utf-8,";
    csvContent += "ID,Type,Entry Time,Exit Time,Duration (seconds)\n"; // CSV Headers

    peopleData.forEach((row) => {
        csvContent += `${row.id},${row.type},${row.entryTime},${row.exitTime},${row.duration}\n`;
    });

    let encodedUri = encodeURI(csvContent);
    let link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "people_flow_data.csv");
    document.body.appendChild(link);
    link.click();
}

// Start simulation
document.getElementById("startButton").addEventListener("click", () => {
    document.getElementById("startButton").disabled = true;
    document.getElementById("stopButton").disabled = false;

    people = []; // Reset people array
    peopleData = []; // Reset data log
    updateSimulation(); // Start movement
    spawnInterval = setInterval(spawnPerson, 1000); // Generate people every second
});

// Stop simulation
document.getElementById("stopButton").addEventListener("click", () => {
    clearInterval(spawnInterval);
    document.getElementById("startButton").disabled = false;
    document.getElementById("stopButton").disabled = true;
    document.getElementById("downloadCsvButton").disabled = false;

    //exportToCSV(); // Generate CSV file with recorded data
});

// Download the CSV
document.getElementById("downloadCsvButton").addEventListener("click", () => {
    exportToCSV();
    document.getElementById("downloadCsvButton").disabled = true; // Disable after downloading
});
