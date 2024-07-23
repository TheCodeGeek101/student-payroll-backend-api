<?php
namespace App\Containers\SchoolsSection\Grades\Actions;

use App\Ship\Actions\SubAction;

class MapPointsToLetterAction extends SubAction
{
    /**
     * Map the grade value (percentage) to an IGCSE letter grade.
     *
     * @param float $gradeValue
     * @return string
     */
    public function run(float $gradeValue): string
    {
        if ($gradeValue >= 90) {
            return 'A*';
        } elseif ($gradeValue >= 80) {
            return 'A';
        } elseif ($gradeValue >= 70) {
            return 'B';
        } elseif ($gradeValue >= 60) {
            return 'C';
        } elseif ($gradeValue >= 50) {
            return 'D';
        } elseif ($gradeValue >= 40) {
            return 'E';
        } elseif ($gradeValue >= 30) {
            return 'F';
        } else {
            return 'U'; // Ungraded
        }
    }
}
