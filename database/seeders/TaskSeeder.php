<?php

// database/seeders/TaskSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use Faker\Factory as Faker;
use Carbon\Carbon;

class TaskSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Create main tasks
        // Create main tasks
        for ($i = 1; $i <= 5; $i++) {
            Task::create([
                'title' => $faker->sentence(3),
                'due_date' => Carbon::parse($faker->dateTimeBetween('now', '+2 weeks')),
                'status' => $faker->randomElement([Task::STATUS_PENDING, Task::STATUS_COMPLETED]),
                'parent_id' => null,
            ]);
        }

        // Create sub-tasks for each main task
        $mainTasks = Task::whereNull('parent_id')->get();
        foreach ($mainTasks as $mainTask) {
            for ($i = 1; $i <= 3; $i++) {
                Task::create([
                    'title' => $faker->sentence(3),
                    'due_date' => Carbon::parse($faker->dateTimeBetween($mainTask->due_date, $mainTask->due_date->addWeek())),
                    'status' => $faker->randomElement([Task::STATUS_PENDING, Task::STATUS_COMPLETED]),
                    'parent_id' => $mainTask->id,
                ]);
            }
        }
    }
}


