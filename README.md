# How to start WeRoad API

## Setup Instructions

### Step 1: Clone the Repository
Clone the repository from GitHub:
```bash
git clone https://github.com/mfonsatti/weroad-api.git
cd weroad-api
```

### Step 2: Start the Project
Ensure you have **Docker** or **Rancher Desktop** running, then execute:
```bash
docker compose up -d
php artisan migrate
php artisan db:seed --class=TravelSeeder
```

### Step 3: Run the Application
Start the Laravel development server:
```bash
php artisan serve
```
The application should be accessible at [localhost:8000](http://localhost:8000).

## Implementation Details

### Repository Pattern
The project follows the **Repository Pattern**, which provides:
- Better separation of concerns.
- Easier maintainability and scalability.

### Database Seeder
A **database seeder** is implemented to populate the `travels` table with sample data.

### Custom Exception Handling
Specific application errors are handled using **custom exceptions**, improving error management.

### Custom Validation
Additional **custom validation rules** ensure that input data meets business requirements.

### Custom Request Handling for Booking
Booking operations are managed through **custom request classes**, ensuring structured validation and request processing.

---
