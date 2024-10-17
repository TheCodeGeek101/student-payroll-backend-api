<?php

namespace App\Containers\SchoolsSection\Timetable\Actions;

use App\Ship\Actions\Action;
use Illuminate\Support\Facades\DB;
use App\Containers\SchoolsSection\Timetable\Requests\StoreTimetableRequest;
use App\Containers\SchoolsSection\Timetable\Data\Models\Timetable;
use App\Containers\UsersSection\Tutors\Data\Models\Tutor;
use App\Containers\SchoolsSection\Subjects\Data\Models\Subject;
use App\Containers\SchoolsSection\Term\Data\Models\AcademicCalendar;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Containers\SchoolsSection\Class\Data\Models\ClassModel;

class CreateTimetableAction extends Action
{
    public function run(ClassModel $class)
    {
        try {
            // Get the active term
            $activeTerm = AcademicCalendar::where('is_active', true)->first();
            if (!$activeTerm) {
                return ['error' => 'No active term found.'];
            }

            // Check if a timetable already exists for the active term
            $existingTimetable = Timetable::where('term_id', $activeTerm->id)->first();
            if ($existingTimetable) {
                return ['error' => 'Timetable already exists for this term.'];
            }

            // Define teaching days and teaching hours
            $teachingDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
            $startTime = 7 * 60; // 7:00 AM in minutes
            $endTime = 15 * 60 + 30; // 3:30 PM in minutes
            $periodDuration = 45; // duration of a single period in minutes
            $maxSubjectDuration = 90; // maximum duration a subject can occupy in minutes
            $periodsPerDay = ($endTime - $startTime) / $periodDuration;

            // Get all subjects for the class
            $subjects = Subject::where('class_id', $class->id)
                ->with('tutors') // Ensure we load the tutors for each subject
                ->get();

            // Prepare timetable slots
            $timetableSlots = [];
            foreach ($teachingDays as $day) {
                foreach ($subjects as $subject) {
                    // Ensure the subject has associated tutors
                    if ($subject->tutors->isEmpty()) {
                        Log::warning('No tutors found for subject: ', [$subject->name]);
                        continue; // Skip subjects with no tutors
                    }

                    // Calculate the number of periods needed per week based on credits
                    $periodsNeeded = $subject->credits; // Assuming credits translate directly to periods per week

                    for ($i = 0; $i < $periodsNeeded; $i++) {
                        // Select a random time slot for each period, ensuring no overlaps
                        $timeSlot = random_int($startTime, $endTime - $maxSubjectDuration);
                        $start = $this->minutesToTime($timeSlot);
                        $end = $this->minutesToTime($timeSlot + $maxSubjectDuration);

                        // Get the list of tutor IDs associated with this subject
                        $tutorIds = $subject->tutors->pluck('id')->toArray();

                        // Check for conflicts before scheduling
                        $conflict = Timetable::whereIn('tutor_id', $tutorIds)
                            ->where('day_of_week', $day)
                            ->where(function ($query) use ($start, $end) {
                                $query->where('start_time', '<', $end)
                                    ->where('end_time', '>', $start);
                            })
                            ->exists();

                        if (!$conflict) {
                            // Randomly select one of the tutors for the subject
                            $selectedTutorId = $tutorIds[array_rand($tutorIds)];

                            $timetableSlots[] = [
                                'subject_id' => $subject->id,
                                'tutor_id' => $selectedTutorId,
                                'day_of_week' => $day,
                                'start_time' => $start,
                                'end_time' => $end,
                                'term_id' => $activeTerm->id,
                                'class_id' => $class->id, // Use the current class
                            ];
                        } else {
                            Log::warning('Conflict found for subject: ', [$subject->name]);
                        }
                    }
                }
            }

            // Insert the timetable slots into the database
            if (count($timetableSlots) > 0) {
                DB::transaction(function () use ($timetableSlots) {
                    foreach ($timetableSlots as $slot) {
                        Timetable::create($slot);
                    }
                });
            } else {
                Log::info('No timetable slots available to create.');
            }

            return ['success' => 'Timetable created successfully.'];

        } catch (Exception $e) {
            return [
                'error' => $e->getMessage()
            ];
        }
    }

    // Convert minutes to HH:MM format
    private function minutesToTime($minutes)
    {
        $hours = floor($minutes / 60);
        $minutes = $minutes % 60;
        return sprintf('%02d:%02d:00', $hours, $minutes); // HH:MM:00
    }
}
