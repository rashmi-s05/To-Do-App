# To-Do List Application

This is a To-Do List application built using Laravel. The API allows users to manage tasks and sub-tasks.

## Functional Requirements

- Users can create a Task or Subtask.
- Users can delete a Task (Soft Delete).
- Users can mark a Task as Complete.
- If the main Task is marked as completed, all related Subtasks are marked as completed.
- Users can view the list of all pending Tasks and Subtasks, sorted by `due-date` (ascending).
- Users can filter Tasks based on `due-date`: Today, This Week, Next Week, Overdue.
- Users can search Tasks based on `title`.
- Scheduler: Tasks that have been soft-deleted for more than a month are permanently deleted.

## Task Properties

- A Task has a `title` and `due-date`.
- There are only two states applicable for a Task: Pending or Completed.
- Tasks can have related Subtasks.

## Installation

1. Clone the repository:

git clone https://github.com/your-username/your-repository.git
cd your-repository

1. Set up the environment:

//Configure your database credentials in the .env file.

2. Run database migrations and seeders:

php artisan migrate --seed

3. Serve the application:

php artisan serve

The application should now be running at http://localhost:8000.

API Endpoints

GET /api/tasks: Get all pending Tasks and their Subtasks.

POST /api/tasks: Create a new Task or Subtask.

PUT /api/tasks/{task}/complete: Mark a Task as Complete.

DELETE /api/tasks/{task}: Delete a Task (Soft Delete).

Filtering
You can filter Tasks by appending a query parameter to the GET /api/tasks endpoint:

?filter=today: Tasks due today.
?filter=this_week: Tasks due this week.
?filter=next_week: Tasks due next week.
?filter=overdue: Overdue tasks.
Searching
You can search for Tasks by appending a query parameter to the GET /api/tasks endpoint:

?search=query: Search Tasks by title containing 'query'.
